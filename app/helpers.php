<?php

use App\Models\Option;

if (! function_exists('build_breadcrumb')) {
    function build_breadcrumb($list)
    {
        $result = "<div style='display:none' class='breadcrumb-detail clearfix' itemscope itemtype='http://schema.org/BreadcrumbList'>";
        $count = 1;
        $array_num = count($list);
        foreach($list as $name=>$link){
            if($link){
                $result .= "
                    <span itemprop='itemListElement' itemscope itemtype='http://schema.org/ListItem'>
                        <a itemprop='item' href='{$link}' class='homepage-link'>
                            <span itemprop='name'>
                                {$name}
                            </span>
                        </a>
                        <meta itemprop='position' content='{$count}' />
                    </span>
                ";
            }else{
                $result .= "
                    <span itemprop='itemListElement' itemscope itemtype='http://schema.org/ListItem'>
                        <span class='page-title'>
                            <span itemprop='name'>
                                {$name}
                            </span>
                        </span>
                        <meta itemprop='position' content='{$count}' />
                    </span>
                ";
            }
            if( $count != $array_num ){
                $result .= "<i class='fa fa-angle-right'></i>";
            }
            $count++;
        }
        $result .= "</div>";
        return $result;
    }
}



//Tạo url route
if (! function_exists('get_url')) {
    function get_url($type,$name,$id){
        $url = '';
        $url_end = '{$name}/{$id}';
        switch($type){
            case 'danhmuc':
                $url = "/" . $url_end;
                break;
            case 'tintuc':
                $url = "/tin-tuc/" .$url_end;
                break;
            case 'danhmuctintuc':
                $url = "/tin-tuc/{$name}/{$id}.xml";
                break;
            case 'sanpham':
                $url = "/san-pham/" .$url_end;
                break;
            case 'danhmucvattu':
                $url = "danhmucvattu/" .$url_end;
                break;
            case 'vattu':
                $url = "/vat-tu/" .$url_end;
                break;
            case 'salepage_v2':
                $url = "/salepage_v2/" .$url_end;
                break;
        }

        return $url;
}
}

//Chuyển chữ có dấu thành không dấu
function utf8convert($str) {
    if(!$str) return false;
    $utf8 = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd'=>'đ|Đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            );
    foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);
    return $str;
}

function utf8tourl($text){
    $text = strtolower(utf8convert($text));
    $text = str_replace( "ß", "ss", $text);
    $text = str_replace( "%", "", $text);
    $text = str_replace( "?", "", $text);
    $text = str_replace( ",", "", $text);
    //$text = preg_replace("/[^_a-zA-Z0-9 -]/", "",$text);
    $text = str_replace(array('%20', ' '), '-', $text);
    $text = str_replace("----","-",$text);
    $text = str_replace("---","-",$text);
    $text = str_replace("--","-",$text);
    return $text;
}
// define here so that it autoload when the application run??? do not need to call Model Option when you need to use
function getOption($optionName){
    $option = Option::getOptionValueByName($optionName);
    return  $option['option_value'];
}
//http://techblog.vn/lap-trinh-vien/chuyen-chuoi-co-dau-sang-khong-sa-1417/
function seo_url($str){
    return utf8tourl( utf8convert($str) );
}

if(! function_exists('converPriceStringToInt')) {
    function converPriceStringToInt($stringPrice){
        return str_replace('.', '', $stringPrice);
    }
}

