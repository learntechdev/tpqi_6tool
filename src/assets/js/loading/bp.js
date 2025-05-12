var bp={
    init: function(){
        $(document).ready(function(){
            window.fbAsyncInit = function() {
              FB.init({
                appId            : '490700891079699',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v2.9'
              });
              FB.AppEvents.logPageView();
            };

            (function(d, s, id){
               var js, fjs = d.getElementsByTagName(s)[0];
               if (d.getElementById(id)) {return;}
               js = d.createElement(s); js.id = id;
               js.src = "//connect.facebook.net/en_US/sdk.js";
               fjs.parentNode.insertBefore(js, fjs);
             }(document, 'script', 'facebook-jssdk'));

            $('.checkbox-title').unbind();
            $('.radio-title').unbind();
            $('.bp-input-enter').unbind();

            $('.checkbox-title').click(function(){
                $(this).parent().find('input[type=checkbox]').click();
            });
            $('.radio-title').click(function(){
                $(this).parent().find('input[type=radio]').click();
            });
            $('.bp-input-enter').keyup(function(event){
                if($(this).attr('enter')!=''){
                    if(event.keyCode==13){
                        var obj=$(this).attr('enter');
                        $(this).parent().find(obj).click();
                    }
                }
            });
        });
    },
    tab: function(tabObj){
        var tabObjName=tabObj;
        var tabObj=$(tabObj);
        var firstTab=tabObj.find("li:first-child").attr('containerName');
        var tabBody=tabObj.next('.bp-tab-body');
        // tabBody.children().not('#'+firstTab).hide();

        tabObj.find('a').removeAttr('href');
        // toastr["info"](tabObjName+" removed");
        tabObj.children().css('cursor','pointer');

        $(tabObj).children().click(function(){
            $(tabObj).scroll();
            var containerName=$(this).attr('containerName');
            tabObj.children().removeClass('active');
            $(this).addClass('active');
            tabBody.children().hide();
            tabBody.children('#'+containerName).show();
            $(tabObj).scroll();
        });
        tabBody.children().hide();
        var activeCount=0;
        $(tabObj).children().each(function(){
            if($(this).hasClass('active')){
                var containerName=$(this).attr('containerName');
                $('#'+containerName).show();
                activeCount++;
            }
        });
        if(activeCount==0){
            $(tabObj).children(":first").click();
        //     $(tabObj).children().each(function(){
        //         var containerName=$(this).attr('containerName');
        //         $('#'+containerName).show();
        //         break;
        //     });
        }
    },
    readURL: function(input,onComplete){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                onComplete(e.target.result)
                // $('#'+targetID).css('background-image', "url('"+e.target.result+"')");
            }

            reader.readAsDataURL(input.files[0]);
        }
    },
    browseOCC: function(onClickOccItem){
        $('#panel-browseOCC').remove();
        $('body')
            .append("<div id='panel-browseOCC' class='panel panel-default'></div>");
        $('#panel-browseOCC')
            .attr("style","position: fixed;top: 45px;right:10px;width: 50%;z-index: 4000;display: none;box-shadow: 0 0 50px rgba(0,0,0,0.3);")
            .append("<div class='panel-heading' style='padding: 5px 15px;background-color: #0d2940;color: #fff;font-size: 130%;'><h4 class='modal-title'>เลือกคุณวุฒิวิชาชีพ</h4> <img src='../tpqi/images/close.png' id='button-closeBrowseOCC' style='cursor: pointer;position: absolute;right: 9px;top: 14px;'></div>")
            .append("<div class='panel-body'></div>")
            .find('.panel-body')
                // .attr("style","overflow: auto; height: calc(100% - 41px)");
        $('#button-closeBrowseOCC')
            .css("cursor","pointer")
            .click(function(){
                $('#panel-browseOCC').fadeOut(function(){
                    $('#panel-browseOCC').remove();
                });
            });
        var boccParent=$('#panel-browseOCC')
        var boccHeading=$('#panel-browseOCC').find('.panel-heading');
        var boccBody=$('#panel-browseOCC').find('.panel-body');

        bp.onClickOccItem=onClickOccItem;

        $.post('../tpqi/gui/browseOcc/index.php',function(data){
            boccBody.html(data);
            $('#bocc-button-search').css('border','1px solid #ebebeb');
            boccBody.css('font-size','120%');
            $(document).click(function(){
                $('#panel-browseOCC').remove();
                $(document).unbind();
            });
            $('#panel-browseOCC').click(function(){
                event.stopPropagation();
            });
        });
        $('#panel-browseOCC').fadeIn();
    },
    showCBInfo: function(orgID){
        $('.modal').modal('hide');
        $(body).find('#modal-bpCBInfo').remove();
        $('body').append('<div id="modal-bpCBInfo" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document" style="width: 60%"><div class="modal-content"><div class="modal-header"><button id="button-closeBPCBInfo" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"><span class="cb-orgName"></span></h4></div><div class="modal-body"></div></div></div></div>');
        $.post('../tpqi/gui/cb/cbInfo.php',{
            orgID: orgID
        },function(data){
            $('#modal-bpCBInfo').find('.modal-body').html(data);
        });
        $('#button-closeBPCBInfo').click(function(){
            setTimeout(function(){
                $('#modal-bpCBInfo').remove();
            },500);
        });
        $('#modal-bpCBInfo').modal('show');
    },
    showPersonInfo: function(personID){
        $('.modal').modal('hide');
        $(body).find('#modal-bpPersonInfo').remove();
        $('body').append('<div id="modal-bpPersonInfo" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document" style="width: 60%"><div class="modal-content"><div class="modal-header"><button id="button-closeBPPersonID" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"><span class="person-personName"></span></h4></div><div class="modal-body"></div></div></div></div>');
        $.post('../tpqi/gui/person/personInfo.php',{
            personID: personID
        },function(data){
            $('#modal-bpPersonInfo').find('.modal-body').html(data);
        });
        $('#button-closeBPPersonID').click(function(){
            setTimeout(function(){
                $('#modal-bpPersonInfo').remove();
            },500);
        });
        $('#modal-bpPersonInfo').modal('show');
    },
    showFirmInfo: function(firmID){
        $('.modal').modal('hide');
        $(body).find('#modal-bpFirmInfo').remove();
        $('body').append('<div id="modal-bpFirmInfo" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document" style="width: 60%"><div class="modal-content"><div class="modal-header"><button id="button-closeBPFirmID" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"><span class="firm-firmName"></span></h4></div><div class="modal-body"></div></div></div></div>');
        $.post('../tpqi/gui/firm/firmInfo.php',{
            firmID: firmID
        },function(data){
            $('#modal-bpFirmInfo').find('.modal-body').html(data);
        });
        $('#button-closeBPFirmID').click(function(){
            setTimeout(function(){
                $('#modal-bpFirmInfo').remove();
            },500);
        });
        $('#modal-bpFirmInfo').modal('show');
    },
    showJobInfo: function(jobID, showBlockForm){
        if(showBlockForm === undefined){
            showBlockForm = false;
        }
        $('.modal').modal('hide');
        $(body).find('#modal-bpJobInfo').remove();
        $('body').append('<div id="modal-bpJobInfo" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document" style="width: 60%"><div class="modal-content"><div class="modal-header"><button id="button-closeBPJobInfo" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"><span class="job-jobName"></span></h4></div><div class="modal-body"></div></div></div></div>');
        $.post('../tpqi/gui/job/click.php',{
            jobID: jobID
        },function(data){

        });
        $.post('gui/job/jobInfo.php',{
            jobID: jobID,
            showBlockForm: showBlockForm
        },function(data){
            $('#modal-bpJobInfo').find('.modal-body').html(data);
        });
        $('#button-closeBPJobInfo').click(function(){
            setTimeout(function(){
                $('#modal-bpJobInfo').remove();
            },500);
        });
        $('#modal-bpJobInfo').modal('show');
    },
    showNewsInfo: function(newsID, showBlockForm){
        if(showBlockForm === undefined){
            showBlockForm = false;
        }
        $('.modal').modal('hide');
        $(body).find('#modal-bpNewsInfo').remove();
        $('body').append('<div id="modal-bpNewsInfo" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog" role="document" style="width: 60%"><div class="modal-content"><div class="modal-header"><button id="button-closeBPNewsInfo" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"><span class="news-newsTitle"></span></h4></div><div class="modal-body"></div></div></div></div>');
        $.post('../tpqi/gui/newsEvent/newsInfo.php',{
            newsID: newsID,
            showBlockForm: showBlockForm
        },function(data){
            $('#modal-bpNewsInfo').find('.modal-body').html(data);
            var html=$('#modal-bpNewsInfo').find('.modal-body').find('.panel-body').html();
            $('#modal-bpNewsInfo').find('.modal-body').html(html);
            var newsTitle=$('#modal-bpNewsInfo').find('.modal-body').find('.newsEvent-title').children('div').html();
            newsTitle= newsTitle.trim();
            $('#modal-bpNewsInfo').find('.news-newsTitle').html(newsTitle);
            $('#modal-bpNewsInfo').find('.newsEvent-related-container').remove();
        });
        $('#button-closeBPNewsInfo').click(function(){
            setTimeout(function(){
                $('#modal-bpNewsInfo').remove();
            },500);
        });
        $('#modal-bpNewsInfo').modal('show');
    },
    setLoading: function(obj,message){
        if(message === undefined){
            message='Loading';
        }
        $(obj).html("<div style='width: 100%;text-align: center;padding-top: 20px;'><i class='fa fa-refresh fa-spin fa-3x fa-fw'></i><br><div>"+message+"</div></div>");
    },
    showLoading: function(){
        $('#loading-container').remove();
        $('body').append("<div id='loading-container'><div><div></div></div></div>");
        $('#loading-container')
            .css('position','fixed')
            .css('display','none')
            .css('width','100%')
            .css('height','100%')
            .css('top',0)
            .css('left',0)
            .css('background-color','rgba(0,0,0,0.5)')
            .css('z-index',3000);
        $('#loading-container>div')
            .css('display','table')
            .css('width','100%')
            .css('height','100%');
        $('#loading-container>div>div')
            .css('display','table-cell')
            .css('width','100%')
            .css('height','100%')
            .css('vertical-align','middle');
        $('#loading-container>div>div')
            .append('<center><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw" style="color: #fff;"></i></center>')
            .append('<div style="color: #fff;text-align: center;padding-top: 10px;">กรุณารอสักครู่..</div>');
        $('#loading-container').fadeIn();
    },
    hideLoading: function(){
        $('#loading-container').fadeOut(function(){
            $(this).remove();
        });
    },
    numOnly: function(event){
        var keyCode=event.which;
        if(keyCode<48 || keyCode>57){
            alert("กรุณากรอกเฉพาะตัวเลขเท่านั้น");
            return false;
        }
    },
    isEmail:function(emailAddress) {
        var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
        // alert( pattern.test(emailAddress) );
        return pattern.test(emailAddress);
    },
    checkEmailInput: function(e,value){
        var keyCode = e.keyCode;
        if(
            keyCode==3639 ||
            keyCode==3636 ||
            keyCode==3660 ||
            keyCode==3657 ||
            keyCode==3656 ||
            keyCode==3659 ||
            keyCode==3655 ||
            keyCode==3637 ||
            keyCode==3658 ||
            keyCode==3633 ||
            keyCode==3661 ||
            keyCode==3640 ||
            keyCode==3641 ||
            keyCode==3638 ||
            keyCode==3647
        ){
            if(value==''){
                alert('อีเมลห้ามเริ่มต้นด้วยอักขระที่คุณป้อน');
                return false;
            }else{
                return true;
            }
        }
    },
    suggest: function(param, onSelect){
        param.urlParam.perPage=20;
        $.post(param.url,param.urlParam,function(data){
            $('#suggest-container').remove();
            $('<div id="suggest-container"></div>').insertAfter(param.inputObj);
            $('#suggest-container')
                .css('position','absolute')
                .css('z-index','1000')
                .css('max-height','300px')
                .css('overflow','auto')
                .css('border-bottom','1px solid #ddd');
            data=JSON.parse(data);
            if(data.result){
                $('#suggest-container').append('<div class="list-group"></div>');
                var count=0;
                $.each(data.result,function(key, subDistrictInfo){
                    var html=subDistrictInfo.html;
                    var name=subDistrictInfo.name;
                    var value=subDistrictInfo.value;
                    if(jQuery.isPlainObject(value)){
                        value=JSON.stringify(value);
                    }

                    $('#suggest-container .list-group').append('<a class="list-group-item bp-hover" value=\''+value+'\' name="'+name+'">'+html+'</a>')
                });
                $('#suggest-container .list-group-item').click(function(){
                    onSelect({
                        html: $(this).html(),
                        value: $(this).attr('value'),
                        name: $(this).attr('name')
                    });
                    $('#suggest-container').remove();
                });
                $('.list-group-item').css('cursor','pointer');
            }
        });
    },
    getPersonJSON: function(personID, response){
        $.post('gui/person/personInfoJSON.php',{
            personID: personID
        },function(data){
            response(data);
        });
    },
    setDatepicker: function(objectID, options){
        // var dpParam={
        //     dateFormat: 'dd/mm/yy',
        //     buttonImageOnly: false,
        //     dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
        //     monthNamesShort: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
        //     changeMonth: true,
        //     changeYear: true,
        //     beforeShow:function(){
        //         if($(this).val()!=""){
        //             var arrayDate=$(this).val().split("/");
        //             arrayDate[2]=parseInt(arrayDate[2])-543;
        //             $(this).val(arrayDate[0]+"/"+arrayDate[1]+"/"+arrayDate[2]);
        //         }
        //         setTimeout(function(){
        //             $.each($(".ui-datepicker-year option"),function(j,k){
        //                 var textYear=parseInt($(".ui-datepicker-year option").eq(j).val())+543;
        //                 $(".ui-datepicker-year option").eq(j).text(textYear);
        //             });
        //         },50);
        //     },
        //     onChangeMonthYear: function(){
        //         setTimeout(function(){
        //             $.each($(".ui-datepicker-year option"),function(j,k){
        //                 var textYear=parseInt($(".ui-datepicker-year option").eq(j).val())+543;
        //                 $(".ui-datepicker-year option").eq(j).text(textYear);
        //             });
        //         },50);
        //     },
        //     onClose:function(){
        //         if($(this).val()!="" && $(this).val()==dateBefore){
        //             var arrayDate=dateBefore.split("/");
        //             arrayDate[2]=parseInt(arrayDate[2])+543;
        //             $(this).val(arrayDate[0]+"/"+arrayDate[1]+"/"+arrayDate[2]);
        //         }
        //     },
        //     onSelect: function(dateText, inst){
        //         dateBefore=$(this).val();
        //         var arrayDate=dateText.split("/");
        //         arrayDate[2]=parseInt(arrayDate[2])+543;
        //         $(this).val(arrayDate[0]+"/"+arrayDate[1]+"/"+arrayDate[2]);
        //     }
        //
        // }
        // if(options){
        //     if('yearRange' in options){
        //         dpParam.yearRange;
        //     }
        // }
        $(objectID).attr('data-provide','datepicker');
        $(objectID).attr('data-date-language','th-th');
        $(objectID).datepicker();
    },
    checkRequire: function(obj){
        $(obj).find('[type=submit]').click(function(){
            var thisObj=$(obj);
            var isAlert=false;
            thisObj.find('input[required]').each(function(){
                if($(this).val()==''){
                    $(this).addClass('bp-pleaseFill');
                    isAlert=true;
                }else{
                    $(this).removeClass('bp-pleaseFill');
                }
            });
            if(isAlert){
                toastr["warning"]("กรุณากรอกข้อมูลในช่องที่มีเครื่องหมาย * ให้ครบถ้วน");
            }
        });
    },
    autoCitizenID: function(obj){
        var pattern=new String("_-____-_____-_-__"); // กำหนดรูปแบบในนี้
        var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
        var returnText=new String("");
        var obj_l=obj.val().length;
        var obj_l2=obj_l-1;
        for(i=0;i<pattern.length;i++){
            if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
                returnText+=obj.val()+pattern_ex;
                obj.val(returnText);
            }
        }
        if(obj_l>pattern.length){
            obj.val(obj.value.substr(0,pattern.length));
        }
    },
    selectMemberEvidence: function(param, onSelect){
        $('#modal-selectMemberEvidence').remove();
        $.post('modal/selectMemberEvidence', param, function(data){
            $('body').append(data);
            selectMemberEvidenceObj.onSelect= onSelect;
            selectMemberEvidenceObj.loadEvidenceFilter=param;
            selectMemberEvidenceObj.loadEvidence();
            $('#modal-selectMemberEvidence').modal('show');
        });
    },
    shareFB: function(URL){
        URL="https://tpqi-net.tpqi.go.th/"+URL;
        FB.ui({
            method: 'share',
            href: URL
        }, function(response){});
    },
    shareTW: function(URL){
        URL="https://tpqi-net.tpqi.go.th/"+URL;
        window.open('https://twitter.com/intent/tweet?text='+URL,"_blank");
    },
    setThumbImage: function(){
        $( ".thumb-image" ).each(function() {
            var attr = $(this).attr('data-image-src');
            if (typeof attr !== typeof undefined && attr !== false) {
                $(this).css('background', 'url('+attr+') center center');
            }
        });
    },
    setCoverImage: function(){
        $( ".cover-image" ).each(function() {
            var attr = $(this).attr('data-image-src');
            if (typeof attr !== typeof undefined && attr !== false) {
                $(this).css('background', 'url('+attr+') center center');
            }
        });
    },
    inputCitizenID: function(obj){
        /* กำหนดรูปแบบข้อความโดยให้ _ แทนค่าอะไรก็ได้ แล้วตามด้วยเครื่องหมาย
        หรือสัญลักษณ์ที่ใช้แบ่ง เช่นกำหนดเป็น  รูปแบบเลขที่บัตรประชาชน
        4-2215-54125-6-12 ก็สามารถกำหนดเป็น  _-____-_____-_-__
        รูปแบบเบอร์โทรศัพท์ 08-4521-6521 กำหนดเป็น __-____-____
        หรือกำหนดเวลาเช่น 12:45:30 กำหนดเป็น __:__:__
        ตัวอย่างข้างล่างเป็นการกำหนดรูปแบบเลขบัตรประชาชน
        */
        obj.keyup(function(event){
            var keyCode= event.keyCode;
            // console.log(keyCode);
            if(keyCode!=8){
                var value= $(this).val();
                var currentLength= value.length;
                if(currentLength<=17){
                    var pattern=new String("_-____-_____-_-__"); // กำหนดรูปแบบในนี้
                    var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
                    var returnText=new String("");
                    var obj_l= value.length;
                    // console.log(obj_l);
                    var obj_l2=obj_l-1;
                    for(i=0;i<pattern.length;i++){
                        if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
                            returnText+=value+pattern_ex;
                            // obj.value=returnText;
                            $(this).val(returnText);
                        }
                    }
                    if(obj_l>=pattern.length){
                        // $(this).val()= $(this).val().substr(0,pattern.length);
                        // $(this).val($(this).val().substr(0,pattern.length));
                    }
                }
            }
        }).keypress(function(event){
            var value= $(this).val();
            var currentLength= value.length;
            if(currentLength>=17){
                return false;
            }
            var keyCode= event.keyCode;
            if(keyCode<48 || keyCode>57){
                // console.log("FALSE");
                return false;
            }
        }).blur(function(){
            var pattern=new String("_-____-_____-_-__"); // กำหนดรูปแบบในนี้
            var pattern_ex=new String("-");
            var value= $(this).val();
            var valueTemp= "";
            value= value.replace(/,/g, "");
            value= value.replace(" ", "");
            for(i=0;i<pattern.length;i++){
                if(pattern.charAt(i)==pattern_ex){
                    valueTemp+= pattern_ex+value.charAt(i);
                }else{
                    valueTemp+= value.charAt(i);
                }
                console.log(i+" : "+valueTemp);
                // console.log(value.charAt(i));
            }
            $(this).val(valueTemp);
        });
    },
    checkCitizenID: function(s){
        var pin = 0 , j = 13 , pin_num = 0;
        if ( s == ""){
            return;
        }
        var ChkPinID = true;
        if( ChkPinID == false ) { return false; }
        if( s.length == 13 ) {
            for(var i = 0; i < s.length; i++ ) {
                if( i != 12 ) {
                    pin = s.charAt(i) * j + pin;
                }
                j --;
            }
            pin_num = ( 11 - ( pin %11 ))%10;
            if( s.charAt(12) != pin_num ) {
                // alert("เลขที่บัตรประจำตัวประชาชนไม่ถูกต้อง กรุณาป้อนเลขที่บัตรประจำตัวประชาชนอีกครั้ง");
                return false;
            }
        }else{
            // alert("เลขที่บัตรประจำตัวประชาชนไม่ถูกต้อง กรุณาป้อนเลขที่บัตรประจำตัวประชาชนอีกครั้ง");
            return false;
        }
        return true;
    }
}
bp.init();


var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();
