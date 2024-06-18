<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded =[];
    public function customer(){
        return $this->hasOne(Customer::class,'id','customer_id');
    }
    public function invoiceDetails(){
        return $this->hasMany(InvoiceDetail::class);
    }
    // public function products(){
    //     return $this->through('invoiceDetails')->hasOne('product');
    // }
    /**
     * The roles that belong to the user.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class,'invoice_details','invoice_id','product_id');
    }
     ////  ------------------ Accessor and multator--------------------------------- ////
     protected function subtotal(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => number_format($value, 0, ',', '.'),
             set: fn ($value) => preg_replace('/\./','',$value),
         );
     }
     protected function amountOff(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => number_format($value, 0, ',', '.'),
             set: fn ($value) => preg_replace('/\./','',$value),
         );
     }
     protected function subtotalDiscounted(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => number_format($value, 0, ',', '.'),
             set: fn ($value) => preg_replace('/\./','',$value),
         );
     }
     protected function shipping(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => number_format($value, 0, ',', '.'),
             set: fn ($value) => preg_replace('/\./','',$value),
         );
     }
     protected function total(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => number_format($value, 0, ',', '.'),
             set: fn ($value) => preg_replace('/\./','',$value),
         );
     }
     protected function date(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => date("d/m/Y",strtotime($value)),
             set: fn ($value) => date('Y-m-d',strtotime($value))// make it the same format with created_at, updated_at..
         );
     }


      ////  ------------------ End Accessor and multator--------------------------------- ////

      //------------------- other function-------------------------------------------------////
      public static function totalByDay($day, $month, $year, $format=false){
        $theday = Carbon::createFromFormat('d-m-Y',  $day.'-'.$month.'-'.$year);
        // $theday = Illuminate\Support\Carbon::createFromFormat('d-m-Y',  '14'.'-'.'6'.'-'.'2024')->daysInMonth;
        $revenues = Invoice::whereDate('date','=',$theday)->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->getRawOriginal('total');
        }
        if($format){
            return number_format($total, 0, ',', '.');
        }else{
            return $total;
        }
      }
      public static function thisDayOfLastWeekTotal($date){
        $thisDayLastWeek = Carbon::now()->subDays(6);
        $revenues = Invoice::whereDate('date','=',$thisDayLastWeek)->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->total;
        }
        return $total;
      }
      public static function thisDayOfLastMonthTotal($date){
        $revenue = Invoice::whereMonth('date','=',date('m'))->first();
        return $revenue?$revenue->total:0;
      }
      public static function thisYearTotal($format=false){
        $start =Carbon::now()->startOfYear();
        $end =Carbon::now();
        $revenues = Invoice::whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->getRawOriginal('total');
        }
        if($format){
            return number_format($total, 0, ',', '.');
        }else{
            return $total;
        }
      }
      public static function lastYearTotal($format=false){
        $start =Carbon::now()->startOfYear()->subYear();
        $end =Carbon::now()->endOfYear()->subYear();
        $revenues = Invoice::whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->getRawOriginal('total');
        }
        if($format){
            return number_format($total, 0, ',', '.');
        }else{
            return $total;
        }
      }
      public static function compareToLastYear($format=false){
        if(Invoice::lastYearTotal()==0 && Invoice::thisYearTotal()==0){
            $result =0;
        }elseif(Invoice::lastYearTotal()==0 && Invoice::thisYearTotal()>0){
            $result =100;
        }else{
            $result = (Invoice::thisYearTotal()-Invoice::lastYearTotal())/Invoice::lastYearTotal()*100;
        }
        if($format){
            return number_format($result, 2, ',', '.') . ' %';
        }else{
            return $result;
        }

      }
      public static function thisMonthTotal($format=false){
        $start =Carbon::now()->startOfMonth();
        $end =Carbon::now()->endOfMonth();
        $revenues = Invoice::whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->getRawOriginal('total');
        }
        if($format){
            return number_format($total, 0, ',', '.');
        }else{
            return $total;
        }
      }
      public static function lastMonthTotal($format=false){
        $start =Carbon::now()->startOfMonth()->subMonth();
        $end =Carbon::now()->endOfMonth()->subMonth();
        $revenues = Invoice::whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->getRawOriginal('total');
        }
        if($format){
            return number_format($total, 0, ',', '.');
        }else{
            return $total;
        }
      }
      public static function compareToLastMonth($format=false){
        if(Invoice::lastMonthTotal()==0 && Invoice::thisMonthTotal()==0){
            $result =0;
        }elseif(Invoice::lastMonthTotal()==0 && Invoice::thisMonthTotal()>0){
            $result =100;
        }else{
            $result = (Invoice::thisMonthTotal()-Invoice::lastMonthTotal())/Invoice::lastMonthTotal()*100;
        }
        if($format){
            return number_format($result, 2, ',', '.') . ' %';
        }else{
            return $result;
        }

      }

      public static function thisWeekTotal($format=false){
        $start =Carbon::now()->startOfWeek();
        $end =Carbon::now();
        $revenues = Invoice::whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->getRawOriginal('total');
        };
        if($format){
            return number_format($total, 0, ',', '.');
        }else{
            return $total;
        }

      }
      public static function lastWeekTotal($format=false){
        $start =Carbon::now()->startOfWeek()->subWeek();
        $end =Carbon::now()->endOfWeek()->subWeek();
        $revenues = Invoice::whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->getRawOriginal('total');
        }
        if($format){
            return number_format($total, 0, ',', '.');
        }else{
            return $total;
        }
      }
      public static function compareToLastWeek($format=false){
        if(Invoice::lastWeekTotal()==0 && Invoice::thisWeekTotal()==0){
            $result =0;
        }elseif(Invoice::lastWeekTotal()==0 && Invoice::thisWeekTotal()>0){
            $result =100;
        }else{
            $result = (Invoice::thisWeekTotal()-Invoice::lastWeekTotal())/Invoice::lastWeekTotal()*100;
        }
        if($format){
            return number_format($result, 2, ',', '.') . ' %';
        }else{
            return $result;
        }

      }
      public static function todayTotal($format=false){
        $revenues = Invoice::whereDate('date','=',Carbon::now())->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->getRawOriginal('total');
        }
        if($format){
            return number_format($total, 0, ',', '.');
        }else{
            return $total;
        }
      }
      public static function yesterdayTotal($format=false){
        $yesterday =Carbon::now()->subDay();
        $revenues = Invoice::whereDate('date','=',$yesterday)->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->getRawOriginal('total');
        }
        if($format){
            return number_format($total, 0, ',', '.');
        }else{
            return $total;
        }
      }
      public static function compareToYesterday($format=false){
        if(Invoice::yesterdayTotal()==0 && Invoice::todayTotal()==0){
            $result =0;
        }elseif(Invoice::yesterdayTotal()==0 && Invoice::todayTotal()>0){
            $result =100;
        }else{
            $result = (Invoice::todayTotal()-Invoice::yesterdayTotal())/Invoice::yesterdayTotal()*100;
        }
        if($format){
            return number_format($result, 2, ',', '.') . ' %';
        }else{
            return $result;
        }

      }
      public static function totalByMonth($month, $year='2024',$format=false){
        // return $currentMonth;
        $start =Carbon::createFromFormat('m-Y',  $month.'-'.$year)->startOfMonth();
        $end =Carbon::createFromFormat('m-Y',  $month.'-'.$year)->endOfMonth();
        $revenues = Invoice::whereDate('date', '>=', $start)->whereDate('date', '<=', $end)->get('total');
        $total =0;
        foreach($revenues as $revenue ){
            $total+= $revenue->getRawOriginal('total');
        }
        if($format){
            return number_format($total, 0, ',', '.');
        }else{
            return $total;
        }
      }
      public static function totalMonthly($year='2024',$format=true){
        $totals = [];
        for($m=1; $m<=12; $m++){
            if(Invoice::totalByMonth($m,$year,false)>0){
                $total['x']='Tháng '.$m;
                $total['y']=Invoice::totalByMonth($m,$year,$format);
                $totals[] = $total;
            }
        }
        return $totals;
      }
      public static function totalInMonthDaily($month='6',$year='2024',$format=true){
        if($month && $year){
            $dayInMonth = Carbon::createFromFormat('m-Y',  $month.'-'.$year)->daysInMonth;
            $totals =[];
            for($d=1; $d<=$dayInMonth; $d++){
                if(Invoice::totalByDay($d,$month,$year,false)>0){
                    $total['x']='Ngày '.$d;
                    $total['y']=Invoice::totalByDay($d,$month,$year,$format);
                    $totals[] = $total;
                }
            }
            return $totals;
        }
      }
      public static function totalThisMonthDaily($format=true){
        $dayInMonth = Carbon::now()->daysInMonth;
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $totals =[];
        for($d=1; $d<=$dayInMonth; $d++){
            if(Invoice::totalByDay($d,$month,$year,false)>0){
                $total['x']='Ngày '.$d;
                $total['y']=Invoice::totalByDay($d,$month,$year,$format);
                $totals[] = $total;
            }
        }
        return $totals;

      }
      public static function totalThisWeekDaily($format=true){
        $totals =[];
        $weekMap = [
            0 => 'Chủ nhật',
            1 => 'Thứ 2',
            2 => 'Thứ 3',
            3 => 'Thứ 4',
            4 => 'Thứ 5',
            5 => 'Thứ 6',
            6 => 'Thứ 7',
        ];
        for($d=0; $d<7; $d++){
            $theday = Carbon::now()->startOfWeek()->addDays($d);
            $revenues = Invoice::whereDate('date','=',$theday)->get('total');
            $total =0;
            foreach($revenues as $revenue ){
                $total+= $revenue->getRawOriginal('total');
            }
            if($total>0){
                $totalOfDay['x']=$weekMap[$theday->dayOfWeek()];
                if($format){
                    $totalOfDay['y'] = number_format($total, 0, ',', '.');
                }else{
                    $totalOfDay['y']=$total;
                }
                $totals[]=$totalOfDay;
            }
        }
        return $totals;
      }
      //end------------------- other function-------------------------------------------------////
}
