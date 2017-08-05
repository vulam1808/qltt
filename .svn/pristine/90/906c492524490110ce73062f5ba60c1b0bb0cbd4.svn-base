/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function loginuser(url){
    var remem = $('#remember').attr('checked');
    if(remem=='checked')remem = 1;
    else remem = 0;
    var mess='';
    
    var username = $('#username').val();
    var password = $('#password').val();
    if(empty(username) && empty(password)){
        $('#show-error').css('display', 'block');
        return;
    }
    if(!empty(username)){
        $('show-error').css('display','none');
    }
    if(empty(username)){     
        $('#show-error').css('display', 'block');
//        $('#show-error').html(mess);
        return;
    }
    if(empty(password)){
       $('#show-error').css('display', 'block');
        return;
    }
    var params = {
        username: username,
        password: calcMD5(password),
        remember:remem
    };
    
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.code == 1) {
            window.location=jItem.url;
        } else {
            if(jItem.code==2){
                mess = 'Tên đăng nhập không đúng<br>';
            }
            if(jItem.code==3){
                mess = 'Mật khẩu không đúng<br>';
            }
            if(jItem.code==4){
                mess = '<li> Bạn vui lòng kiểm tra lại thông tin đăng nhập.</li>';
            }
            if(mess !==''){
                $('#show-error').html(mess);
                $('#show-error').css('display','block');
                return;
            }
        }
    });
}

function empty(oVal)
{
    if(oVal == 'undefined' || $.trim(oVal) == '' || oVal == '' || oVal == null) return true;
    return false;
}
/*md5*/
/*
 * A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
 * Digest Algorithm, as defined in RFC 1321.
 * Copyright (C) Paul Johnston 1999 - 2000.
 * Updated by Greg Holt 2000 - 2001.
 * See http://pajhome.org.uk/site/legal.html for details.
 */

/*
 * Convert a 32-bit number to a hex string with ls-byte first
 */
var hex_chr = "0123456789abcdef";
function rhex(num)
{
    str = "";
    for(j = 0; j <= 3; j++)
        str += hex_chr.charAt((num >> (j * 8 + 4)) & 0x0F) +
        hex_chr.charAt((num >> (j * 8)) & 0x0F);
    return str;
}

/*
 * Convert a string to a sequence of 16-word blocks, stored as an array.
 * Append padding bits and the length, as described in the MD5 standard.
 */
function str2blks_MD5(str)
{
    nblk = ((str.length + 8) >> 6) + 1;
    blks = new Array(nblk * 16);
    for(i = 0; i < nblk * 16; i++) blks[i] = 0;
    for(i = 0; i < str.length; i++)
        blks[i >> 2] |= str.charCodeAt(i) << ((i % 4) * 8);
    blks[i >> 2] |= 0x80 << ((i % 4) * 8);
    blks[nblk * 16 - 2] = str.length * 8;
    return blks;
}

/*
 * Add integers, wrapping at 2^32. This uses 16-bit operations internally 
 * to work around bugs in some JS interpreters.
 */
function add(x, y)
{
    var lsw = (x & 0xFFFF) + (y & 0xFFFF);
    var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
    return (msw << 16) | (lsw & 0xFFFF);
}

/*
 * Bitwise rotate a 32-bit number to the left
 */
function rol(num, cnt)
{
    return (num << cnt) | (num >>> (32 - cnt));
}

/*
 * These functions implement the basic operation for each round of the
 * algorithm.
 */
function cmn(q, a, b, x, s, t)
{
    return add(rol(add(add(a, q), add(x, t)), s), b);
}
function ff(a, b, c, d, x, s, t)
{
    return cmn((b & c) | ((~b) & d), a, b, x, s, t);
}
function gg(a, b, c, d, x, s, t)
{
    return cmn((b & d) | (c & (~d)), a, b, x, s, t);
}
function hh(a, b, c, d, x, s, t)
{
    return cmn(b ^ c ^ d, a, b, x, s, t);
}
function ii(a, b, c, d, x, s, t)
{
    return cmn(c ^ (b | (~d)), a, b, x, s, t);
}

/*
 * Take a string and return the hex representation of its MD5.
 */
function calcMD5(str)
{
    x = str2blks_MD5(str);
    a =  1732584193;
    b = -271733879;
    c = -1732584194;
    d =  271733878;

    for(i = 0; i < x.length; i += 16)
    {
        olda = a;
        oldb = b;
        oldc = c;
        oldd = d;

        a = ff(a, b, c, d, x[i+ 0], 7 , -680876936);
        d = ff(d, a, b, c, x[i+ 1], 12, -389564586);
        c = ff(c, d, a, b, x[i+ 2], 17,  606105819);
        b = ff(b, c, d, a, x[i+ 3], 22, -1044525330);
        a = ff(a, b, c, d, x[i+ 4], 7 , -176418897);
        d = ff(d, a, b, c, x[i+ 5], 12,  1200080426);
        c = ff(c, d, a, b, x[i+ 6], 17, -1473231341);
        b = ff(b, c, d, a, x[i+ 7], 22, -45705983);
        a = ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
        d = ff(d, a, b, c, x[i+ 9], 12, -1958414417);
        c = ff(c, d, a, b, x[i+10], 17, -42063);
        b = ff(b, c, d, a, x[i+11], 22, -1990404162);
        a = ff(a, b, c, d, x[i+12], 7 ,  1804603682);
        d = ff(d, a, b, c, x[i+13], 12, -40341101);
        c = ff(c, d, a, b, x[i+14], 17, -1502002290);
        b = ff(b, c, d, a, x[i+15], 22,  1236535329);    

        a = gg(a, b, c, d, x[i+ 1], 5 , -165796510);
        d = gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
        c = gg(c, d, a, b, x[i+11], 14,  643717713);
        b = gg(b, c, d, a, x[i+ 0], 20, -373897302);
        a = gg(a, b, c, d, x[i+ 5], 5 , -701558691);
        d = gg(d, a, b, c, x[i+10], 9 ,  38016083);
        c = gg(c, d, a, b, x[i+15], 14, -660478335);
        b = gg(b, c, d, a, x[i+ 4], 20, -405537848);
        a = gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
        d = gg(d, a, b, c, x[i+14], 9 , -1019803690);
        c = gg(c, d, a, b, x[i+ 3], 14, -187363961);
        b = gg(b, c, d, a, x[i+ 8], 20,  1163531501);
        a = gg(a, b, c, d, x[i+13], 5 , -1444681467);
        d = gg(d, a, b, c, x[i+ 2], 9 , -51403784);
        c = gg(c, d, a, b, x[i+ 7], 14,  1735328473);
        b = gg(b, c, d, a, x[i+12], 20, -1926607734);
    
        a = hh(a, b, c, d, x[i+ 5], 4 , -378558);
        d = hh(d, a, b, c, x[i+ 8], 11, -2022574463);
        c = hh(c, d, a, b, x[i+11], 16,  1839030562);
        b = hh(b, c, d, a, x[i+14], 23, -35309556);
        a = hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
        d = hh(d, a, b, c, x[i+ 4], 11,  1272893353);
        c = hh(c, d, a, b, x[i+ 7], 16, -155497632);
        b = hh(b, c, d, a, x[i+10], 23, -1094730640);
        a = hh(a, b, c, d, x[i+13], 4 ,  681279174);
        d = hh(d, a, b, c, x[i+ 0], 11, -358537222);
        c = hh(c, d, a, b, x[i+ 3], 16, -722521979);
        b = hh(b, c, d, a, x[i+ 6], 23,  76029189);
        a = hh(a, b, c, d, x[i+ 9], 4 , -640364487);
        d = hh(d, a, b, c, x[i+12], 11, -421815835);
        c = hh(c, d, a, b, x[i+15], 16,  530742520);
        b = hh(b, c, d, a, x[i+ 2], 23, -995338651);

        a = ii(a, b, c, d, x[i+ 0], 6 , -198630844);
        d = ii(d, a, b, c, x[i+ 7], 10,  1126891415);
        c = ii(c, d, a, b, x[i+14], 15, -1416354905);
        b = ii(b, c, d, a, x[i+ 5], 21, -57434055);
        a = ii(a, b, c, d, x[i+12], 6 ,  1700485571);
        d = ii(d, a, b, c, x[i+ 3], 10, -1894986606);
        c = ii(c, d, a, b, x[i+10], 15, -1051523);
        b = ii(b, c, d, a, x[i+ 1], 21, -2054922799);
        a = ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
        d = ii(d, a, b, c, x[i+15], 10, -30611744);
        c = ii(c, d, a, b, x[i+ 6], 15, -1560198380);
        b = ii(b, c, d, a, x[i+13], 21,  1309151649);
        a = ii(a, b, c, d, x[i+ 4], 6 , -145523070);
        d = ii(d, a, b, c, x[i+11], 10, -1120210379);
        c = ii(c, d, a, b, x[i+ 2], 15,  718787259);
        b = ii(b, c, d, a, x[i+ 9], 21, -343485551);

        a = add(a, olda);
        b = add(b, oldb);
        c = add(c, oldc);
        d = add(d, oldd);
    }
    return rhex(a) + rhex(b) + rhex(c) + rhex(d);
}
//HAM DUNG CHO TAT CA CAC COMBOBOX
function combo(province_i,selectionlog_i){
     $(document).ready(function(){       
       var orderCount = 0;
        $('#'+province_i+'').multiselect({
            maxHeight: '300',
            enableFiltering: true,
            maxHeight: '300',
            onChange: function(option, checked) {
                if (checked) {
                    orderCount++;
                    $(option).data('order', orderCount);
                }
                else {
                    $(option).data('order', '');
                }
            },           
        });        
        $('#'+province_i+'').on('change', function(){
            var selected = [];
            $('#'+province_i+' option:selected').each(function() {
                selected.push([$(this).val(), $(this).data('order')]);
            }); 
            selected.sort(function(a, b) {
                return a[1] - b[1];
            }); 
            var text = '';
            for (var i = 0; i < selected.length; i++) {
                text += selected[i][0] + ', ';
            }
            text = text.substring(0, text.length - 2); 
            $('#'+selectionlog_i+'').val(text);
            $('#'+selectionlog_i+'').text(text);
        });        
     });
 }
 ////////vinh
 function delConfirm(module,controller,action,id,text,text1){           
        bootbox.confirm(text, function(confirmed) {   
            if(confirmed)                
            {                       
                $.getJSON('/pvf/'+module+'/'+controller+'/'+'delconfirm?id='+id ,function(data){                    
                    if(data>0) bootbox.alert(text1);                    
                    else
                    {
                        var $div = $('<div id="alert_success" class="alert alert-success" role="alert" style="width:150px;text-align:center;">Xóa thành công!</div>');
                        $( "body" ).append($div);                                 
                        var top = ($(window).height() - $div.outerHeight()) / 2;
                        var left = ($(window).width() - $div.outerWidth()) / 2;  

                        $div.css({position:'absolute', margin:0, top: (top > 0 ? top : 0)+'px', left: (left > 0 ? left : 0)+'px'});                                                
                        $div.show();
                        $div.delay(5000).hide(0,function(){});

                        window.location='/pvf/'+module+'/'+controller+'/'+action+'?id='+id;                
                    }                     
                });                                  
            }            
        });        
    }
 function getDistrict(url, province_id, element_id, errorMessage) {
    var params = {
        action: 'getdistrict',
        province_id: province_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+element_id).html(jItem.html);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 }
function getAgent(url, area_id, element_id, errorMessage) {
    var params = {
        action:'getagent',
        area_id: area_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+element_id).html(jItem.html);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    }); 
}
 function getProduct(url, agent_id, element_id, errorMessage) {
    var params = {
        action:'getproduct',
        agent_id: agent_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+element_id).html(jItem.html);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
}
function getProvince(url, area_id, element_id, errorMessage) {
    var params = {
        action: 'getprovince',
        area_id: area_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+element_id).html(jItem.html);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
}
function getFactor(url, agent_id,product_id,area_id,date_id,element_id1,element_id2,element_id3, errorMessage) {
    var params = {
        action: 'getfactor',
        agent_id: agent_id,
        product_id:product_id,
        area_id:area_id,
        date_id:date_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html1 != '') {
            $('#'+element_id1).html(jItem.html);
            $('#'+element_id2).html(jItem.html1);
            $('#'+element_id3).html(jItem.html2);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
}
function getStore(url, area_id, element_id1,element_id2, errorMessage) {
    var params = {
        action:'getagent',
        area_id: area_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+element_id1).html(jItem.html),
            $('#'+element_id2).html(jItem.html1);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    }); 
}
 function getHTML(url, agent_id,product_id,order_created, element_id,element_id1,element_id2,element_id3, errorMessage) {
    var params = {
        action:'getproduct',
        agent_id: agent_id,
        product_id:product_id,
        order_created:order_created
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+element_id1).html(jItem.html1);
            $('#'+element_id2).html(jItem.html2);
            $('#'+element_id3).html(jItem.html3);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
}

function getDistrict1(url,province_id,district_id,product_id,factor_id,quantity_id,charges_id, errorMessage) {
    var params = {
        action: 'getdistrict',
        province_id: province_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+district_id).html(jItem.html);
            $('#'+product_id).html(jItem.html1);
            $('#'+factor_id).html(jItem.html2);
            $('#'+quantity_id).html(jItem.html3);
            $('#'+charges_id).html(jItem.html4);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 }   
 
 function getAgent1(url, area_id, agent_id,product_id,factor_id,quantity_id,charges_id, errorMessage) {
    var params = {
        action:'getagentbydistrict',
        area_id: area_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+agent_id).html(jItem.html);
            $('#'+product_id).html(jItem.html1);
            $('#'+factor_id).html(jItem.html2);
            $('#'+quantity_id).html(jItem.html3);
            $('#'+charges_id).html(jItem.html4);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });     
}
//phi hard code
function getAgent4(url, area_id, agent_id,product_id,factor_id,quantity_id,charges_id, errorMessage) {
    var params = {
        action:'getagentbydistrict',
        area_id: area_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
           $('#agent').html(jItem.html);
            $('#'+agent_id).multiselect({
            enableFiltering: true,
            maxHeight: '300'});
            $('#'+product_id).html(jItem.html1);
            $('#'+factor_id).html(jItem.html2);
            $('#'+quantity_id).html(jItem.html3);
            $('#'+charges_id).html(jItem.html4);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });     
}
function getAgent2(url, area_id, agent_id,product_id,factor_id,quantity_id,charges_id, errorMessage) {
    var params = {
        action:'getagentbyprovince',
        area_id: area_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+agent_id).html(jItem.html);
            $('#'+product_id).html(jItem.html1);
            $('#'+factor_id).html(jItem.html2);
            $('#'+quantity_id).html(jItem.html3);
            $('#'+charges_id).html(jItem.html4);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });     
}
//Phi hard code
function getAgent3(url, area_id, agent_id,product_id,factor_id,quantity_id,charges_id, errorMessage) {
    var params = {
        action:'getagentbyprovince',
        area_id: area_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#agent').html(jItem.html);
            $('#'+agent_id).multiselect({
            enableFiltering: true,
            maxHeight: '300'});
            $('#'+product_id).html(jItem.html1);
            $('#'+factor_id).html(jItem.html2);
            $('#'+quantity_id).html(jItem.html3);
            $('#'+charges_id).html(jItem.html4);
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });     
}

function getNewsDetail(url,news_id,title_id,description,content_id){
    
    var params={
      news_id:news_id 
    };
    $.post(url,params,function(datas){
        $('#myModal').modal('show'); 
        var items=datas.split('[]');
        if(items[0]!=''){
           $('#title').html(items[0]);
           $('#description').html(items[1]);
           $('#content').html(items[2]);
        }
    });
}
function getAgentAndDistrict(url)
{        
    getDistrict1(url+'default/service/index',$('#province_id').val(),'district_id','product_id','factor_id','quantity_id','charges_id','Xin Chờ Trong Giây Lát');
    //getAgent2(url+'default/service/index',$('#province_id').val(),'agent_id','product_id','factor_id','quantity_id','charges_id','Xin Chờ Trong Giây Lát');
    //Phi hard code
    getAgent3(url+'default/service/index',$('#province_id').val(),'agent_id','product_id','factor_id','quantity_id','charges_id','Xin Chờ Trong Giây Lát');
}

function regetAgentbyProvince(url)
{
    if($("#district_id").val()=="0") getAndDistrict(url);
    else
    //getAgent1(url+'default/service/index',$('#district_id').val(),'agent_id','product_id','factor_id','quantity_id','charges_id','Xin Chờ Trong Giây Lát');
    getAgent4(url+'default/service/index',$('#district_id').val(),'agent_id','product_id','factor_id','quantity_id','charges_id','Xin Chờ Trong Giây Lát');
}
//ham tu tao
function getDistrictProvince(url, master_province_id,master_district_id,master_ward_id, errorMessage) {
    var params = {
        action: 'getdistrict',
        master_province_id: master_province_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_district_id).html(jItem.html);
            $('#'+master_district_id).multiselect('rebuild');
            $('#'+master_ward_id).html(jItem.html1);
            $('#'+master_ward_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getDistrictProvinceSchedule(url, master_province_id,master_district_id,master_ward_id, errorMessage) {
    var params = {
        action: 'getdistrictschedule',
        master_province_id: master_province_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_district_id).html(jItem.html);
            $('#'+master_district_id).multiselect('rebuild');
            $('#'+master_ward_id).html(jItem.html1);
            $('#'+master_ward_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getDistrictProvincedefault(url, master_province_id,master_district_id, errorMessage) {
    var params = {
        action: 'getdistrict',
        master_province_id: master_province_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_district_id).html(jItem.html);
            $('#'+master_district_id).multiselect('rebuild');
//            enableFiltering: true,
//            maxHeight: '300'
//            });
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getDistrictProvinceleader(url, master_province_id,master_district_id, errorMessage) {
    var params = {
        action: 'getdistrict',
        master_province_id: master_province_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_district_id).html(jItem.html);
            $('#'+master_district_id).multiselect('rebuild');
//            enableFiltering: true,
//            maxHeight: '300'
//            });
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 
 function getDistrictProvincemaster(url, master_province_id,master_district_id, errorMessage) {
    var params = {
        action: 'getdistrict',
        master_province_id: master_province_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_district_id).html(jItem.html);
            $('#'+master_district_id).multiselect('rebuild');
//            enableFiltering: true,
//            maxHeight: '300'
//            });
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getSysUserDepartment(url, sys_department_id,sys_user_id, errorMessage) {
    var params = {
        action: 'getsysuser',
        sys_department_id: sys_department_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+sys_user_id).html(jItem.html);
            $('#'+sys_user_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getSysUserDepartmentdefault(url, sys_department_id,sys_user_id, errorMessage) {
    var params = {
        action: 'getsysuser',
        sys_department_id: sys_department_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+sys_user_id).html(jItem.html);
            $('#'+sys_user_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getSysUserDepartment2(url, sys_department_id,sys_user_id, errorMessage) {
    var params = {
        action: 'getsysuser2',
        sys_department_id: sys_department_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+sys_user_id).html(jItem.html);
            $('#'+sys_user_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getSysUserDepartment1(url, sys_department_id,sys_user_id, errorMessage) {
    var params = {
        action: 'getsysuser1',
        sys_department_id: sys_department_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+sys_user_id).html(jItem.html);
            $('#'+sys_user_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getSysUserDepartmentmaster(url, sys_department_id,sys_user_id, errorMessage) {
    var params = {
        action: 'getsysuser1',
        sys_department_id: sys_department_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+sys_user_id).html(jItem.html);
            $('#'+sys_user_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getSysUserDepartmentleader(url, sys_department_id,sys_user_id, errorMessage) {
    var params = {
        action: 'getsysuser1',
        sys_department_id: sys_department_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+sys_user_id).html(jItem.html);
            $('#'+sys_user_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getPrintCreateMasterPrint(url, master_print_id,doc_print_create_id, errorMessage) {
    var params = {
        action: 'getprintcreate',
        master_print_id: master_print_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+doc_print_create_id).html(jItem.html);
            $('#'+doc_print_create_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getPrintCreateMasterPrint1(url, master_print_id,doc_print_create_id,sys_department_id, errorMessage) {
    var params = {
        action: 'getprintcreate1',
        master_print_id: master_print_id,
        sys_department_id:sys_department_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') 
        {
            $('#'+doc_print_create_id).html(jItem.html);
            $('#'+doc_print_create_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 
 function getPrintCreateMasterPrintdefault(url, master_print_id,doc_print_create_id, errorMessage) {
    var params = {
        action: 'getprintcreate1',
        master_print_id: master_print_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+doc_print_create_id).html(jItem.html);
            $('#'+doc_print_create_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 }
 
 function getPrintCreateMasterPrintmaster(url, master_print_id,doc_print_create_id, errorMessage) {
    var params = {
        action: 'getprintcreate',
        master_print_id: master_print_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+doc_print_create_id).html(jItem.html);
            $('#'+doc_print_create_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getDocPrintCreateMasterPrint(url, master_print_id, sys_department_id,doc_print_create_id, errorMessage) {
    var params = {
        action: 'getdocprintcreate',
        master_print_id: master_print_id,
        sys_department_id:sys_department_id       
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+doc_print_create_id).html(jItem.html);
            $('#'+doc_print_create_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getDocPrintCreateMasterPrintdefault(url, master_print_id, sys_department_id,doc_print_create_id, errorMessage) {
    var params = {
        action: 'getdocprintcreate',
        master_print_id: master_print_id,
        sys_department_id:sys_department_id       
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+doc_print_create_id).html(jItem.html);
            $('#'+doc_print_create_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getMasterPrintDepartment(url, sys_department_id,master_print_id, errorMessage) {
    var params = {
        action: 'getmasterprint',
        sys_department_id: sys_department_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_print_id).html(jItem.html);
            $('#'+master_print_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getMasterPrintDepartmentdefault(url, sys_department_id,master_print_id, errorMessage) {
    var params = {
        action: 'getmasterprint',
        sys_department_id: sys_department_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_print_id).html(jItem.html);
            $('#'+master_print_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
function getMasterPrintSerial(url, master_print_id,sys_department_id,doc_print_allocation_id, errorMessage) {
    var params = {
        action: 'getserialallocation',
        master_print_id: master_print_id,
        sys_department_id: sys_department_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+doc_print_allocation_id).html(jItem.html);
            $('#'+doc_print_allocation_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getDistrict1(url, master_province_id,master_district_id, errorMessage) {
    var params = {
        action: 'getdistrict',
        province_id: master_province_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_district_id).html(jItem.html);
            $('#'+district_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 }  
 function getWard1(url, district_id,ward_id, errorMessage) {
    var params = {
        action: 'getward',
        district_id: district_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+ward_id).html(jItem.html);
            $('#'+ward_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 }   
 function getWardDistrictdefault(url, master_district_id,master_ward_id, errorMessage) {
    var params = {
        action: 'getward',
        master_district_id: master_district_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_ward_id).html(jItem.html);
            $('#'+master_ward_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getWardDistrictleader(url, master_district_id,master_ward_id, errorMessage) {
    var params = {
        action: 'getward',
        master_district_id: master_district_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_ward_id).html(jItem.html);
            $('#'+master_ward_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getWardDistrictmaster(url, master_district_id,master_ward_id, errorMessage) {
    var params = {
        action: 'getward',
        master_district_id: master_district_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_ward_id).html(jItem.html);
            $('#'+master_ward_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getWardDistrict(url, master_district_id,master_ward_id, errorMessage) {
    var params = {
        action: 'getward',
        master_district_id: master_district_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_ward_id).html(jItem.html);
            $('#'+master_ward_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getWardDistrictSchedule(url, master_district_id,master_ward_id, errorMessage) {
    var params = {
        action: 'getwardschedule',
        master_district_id: master_district_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_ward_id).html(jItem.html);
            $('#'+master_ward_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
 function getWardDistrictSchedule(url, master_district_id,master_ward_id, errorMessage) {
    var params = {
        action: 'getwardschedule',
        master_district_id: master_district_id
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_ward_id).html(jItem.html);
            $('#'+master_ward_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 } 
//function getDistrictWithProvince(url)
//{        
//    getDistrictProvince(url+'admin/service/index',$('#master_province_id').val(),'master_district_id','Xin Chờ Trong Giây Lát');
//   
//}
function getDistrictWithProvinceSchedule(url)
{        
    getDistrictProvinceSchedule(url,$('#master_province_id').val(),'master_district_id','master_ward_id','Xin Chờ Trong Giây Lát');
   
}
function getDistrictWithProvince(url)
{        
    getDistrictProvince(url,$('#master_province_id').val(),'master_district_id','master_ward_id','Xin Chờ Trong Giây Lát');
   
}
function getDistrictWithProvincedefault(url)
{        
    getDistrictProvincedefault(url+'default/service/index',$('#master_province_id').val(),'master_district_id','Xin Chờ Trong Giây Lát');
   
}
function getDistrictWithProvinceleader(url)
{        
    getDistrictProvinceleader(url+'leader/service/index',$('#master_province_id').val(),'master_district_id','Xin Chờ Trong Giây Lát');
   
}
function getDistrictWithProvincemaster(url)
{        
    getDistrictProvincemaster(url+'master/service/index',$('#master_province_id').val(),'master_district_id','Xin Chờ Trong Giây Lát');
   
}
function getSysUserWithDepartment(url)
{        
  getSysUserDepartment(url,$('#sys_department_id').val(),'sys_user_id','Xin Chờ Trong Giây Lát');
}

function getSysUserWithDepartmentdefault(url)
{        
  getSysUserDepartmentdefault(url+'default/service/index',$('#sys_department_id').val(),'sys_user_id','Xin Chờ Trong Giây Lát');
}
function getSysUserWithDepartment2(url)
{        
  getSysUserDepartment2(url+'master/service/index',$('#sys_department_id').val(),'sys_user_id','Xin Chờ Trong Giây Lát');
}
function getSysUserWithDepartment1(url)
{        
  getSysUserDepartment1(url,$('#sys_department_id').val(),'sys_user_id','Xin Chờ Trong Giây Lát');
}
function getSysUserWithDepartmentmaster(url)
{        
  getSysUserDepartmentmaster(url+'master/service/index',$('#sys_department_id').val(),'sys_user_id','Xin Chờ Trong Giây Lát');
}
function getDepartmentMasterPrintWithSerial(url,sys_department_id)
{        
    getMasterPrintSerial(url+'admin/service/index',$('#master_print_id').val(),sys_department_id,'doc_print_allocation_id','Xin Chờ Trong Giây Lát');
   
}
//function getWardWithDistrict(url)
//{        
//    getWardDistrict(url+'admin/service/index',$('#master_district_id').val(),'master_ward_id','Xin Chờ Trong Giây Lát');
//   
//}
function getWardWithDistrict(url)
{        
    getWardDistrict(url,$('#master_district_id').val(),'master_ward_id','Xin Chờ Trong Giây Lát');
   
}
function getWardWithDistrictSchedule(url)
{    
    $('#district_id').val($('#master_district_id').val());
    getWardDistrictSchedule(url,$('#district_id').val(),'master_ward_id','Xin Chờ Trong Giây Lát');
   
}
function getWardWithDistrictdefault(url)
{        
    getWardDistrictdefault(url+'default/service/index',$('#master_district_id').val(),'master_ward_id','Xin Chờ Trong Giây Lát');
   
}
function getWardWithDistrictleader(url)
{        
    getWardDistrictleader(url+'leader/service/index',$('#master_district_id').val(),'master_ward_id','Xin Chờ Trong Giây Lát');
   
}

function getWardWithDistrictmaster(url)
{        
    getWardDistrictmaster(url+'master/service/index',$('#master_district_id').val(),'master_ward_id','Xin Chờ Trong Giây Lát');
   
}
function getMasterPrintWithDepartment(url)
{        
    getMasterPrintDepartment(url,$('#sys_department_id').val(),'master_print_id','Xin Chờ Trong Giây Lát');
}
function getMasterPrintWithDepartmentdefault(url)
{        
    getMasterPrintDepartmentdefault(url+'default/service/index',$('#sys_department_id').val(),'master_print_id','Xin Chờ Trong Giây Lát');
}
function getDocPrintCreatWithMasterPrint(url)
{  
    getDocPrintCreateMasterPrint(url+'admin/service/index',$('#master_print_id').val(),$('#sys_department_id').val(),'doc_print_create_id','Xin Chờ Trong Giây Lát');
}
function getDocPrintCreatWithMasterPrintdefault(url)
{  
    getDocPrintCreateMasterPrintdefault(url+'default/service/index',$('#master_print_id').val(),$('#sys_department_id').val(),'doc_print_create_id','Xin Chờ Trong Giây Lát');
}
function getPrintCreatWithMasterPrint(url)
{  
    getPrintCreateMasterPrint(url,$('#master_print_id').val(),'doc_print_create_id','Xin Chờ Trong Giây Lát');
}
function getPrintCreatWithMasterPrint1(url)
{  
    getPrintCreateMasterPrint1(url+'admin/service/index',$('#master_print_id').val(),'doc_print_create_id',$('#sys_department_id').val(),'Xin Chờ Trong Giây Lát');
}
function getPrintCreatWithMasterPrint11(url)
{  
    getPrintCreateMasterPrint1(url+'default/service/index',$('#master_print_id').val(),'doc_print_create_id','Xin Chờ Trong Giây Lát');
}
function getPrintCreatWithMasterPrintdefault(url)
{  
    getPrintCreateMasterPrintdefault(url+'default/service/index',$('#master_print_id').val(),'doc_print_create_id','Xin Chờ Trong Giây Lát');
}
function getPrintCreatWithMasterPrintmaster(url)
{  
    getPrintCreateMasterPrintmaster(url+'master/service/index',$('#master_print_id').val(),'doc_print_create_id','Xin Chờ Trong Giây Lát');
}

function arrayserial(string){
    var arrayserial = new Array();var k=0;
     var serial = string.split(/,/);
      for(var i=0;i<serial.length;i++){
         var serial1 = serial[i].split(/-/);
         if(serial1.length==1){
             arrayserial[k++]= serial1[0];
         }else{
             for( var l = serial1[0];l<= serial1[1];l++){
               arrayserial[k++]= l;  
             }
         }
     }
     return arrayserial;
}
//tim va tra ve vi vi phan tu tim thay trong mang
function findint(int,array){
         var a = new Array();
         a = array;var dem = 0;var vitri = -1;
         for(var i = 0 ; i< a.length; i++){
             if(a[i]==int){
                 dem= 1;vitri = i;
                 break;
             }
         }
         if(dem == 1){
            return vitri;
         }else{
            return -1; 
         }
     }
///
 function ckeckint(int,array){
         var a = new Array();
         a = array;var dem = 0;
         for(var i = 0 ; i< a.length; i++){
             if(a[i]==int){
                 dem= 1;
                 break;
             }
         }
         return dem;
     }
function checkserial(array1,array2){
    var demm = 0;
    for(var i =0;i<array2.length;i++){
        if(ckeckint(array2[i],array1)==0){
            demm =1;break;
        }
    }
    return demm;
}
function array(array11,array22){
    var array12 = new Array();var i=0;
    for(var ii = 0;ii<array11.length;ii++){
        array12[i++]=array11[ii];
    }
    if(i==array11.length){
        for(var iii = 0;iii<array22.length;iii++){
            array12[i++]=array22[iii];
        }
    }
    return array12;
}
function getInfoScheduleWithDepartmentcbd(url)
{        
    getInfoScheduleDepartmentcbd(url,$('#sys_department_id').val(),'info_schedule_id','Xin Chờ Trong Giây Lát');
}
function getInfoScheduleDepartmentcbd(url,sys_department_id,info_schedule_id,errorMessage) {
    var params = {
        action: 'getInfoSchedule',
        sys_department_id: sys_department_id,
       
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+info_schedule_id).html(jItem.html);
            $('#'+info_schedule_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 }  
function getMasterPrintWithDepartmentcbd(url,user,masterprint,infoscheduleid)
{        
    getMasterPrintDepartmentcbd(url,$('#sys_department_id').val(),'master_print_id','sys_user_id','doc_print_create_id','cobo_id','info_schedule_id',user,masterprint,infoscheduleid,'Xin Chờ Trong Giây Lát');
}

function getMasterPrintDepartmentcbd(url,sys_department_id,master_print_id,sys_user_id,doc_print_create_id,cobo_id,info_schedule_id,user,masterprint,infoscheduleid,errorMessage) {
    var params = {
        action: 'getmasterprint12',
        sys_department_id: sys_department_id,
        user:user,
        masterprint:masterprint,
        infoscheduleid:infoscheduleid
    };
    $.post(url, params, function(datas) {
        var items = eval(datas);
        var jItem = items[0];
        if (jItem.html != '') {
            $('#'+master_print_id).html(jItem.html);
            $('#'+sys_user_id).html(jItem.html1);
            $('#'+doc_print_create_id).html(jItem.html2);
            $('#'+info_schedule_id).html(jItem.html3);
            $('#'+master_print_id).multiselect('rebuild');
            $('#'+sys_user_id).multiselect('rebuild');
            $('#'+doc_print_create_id).multiselect('rebuild');
            $('#'+info_schedule_id).multiselect('rebuild');
        } else {
            if (errorMessage != '' && errorMessage != null) {
                alert(errorMessage);
            }
        }
    });
 }  