<?php
/*
     http://localhost/Development/BSP01/BSP/php/CRUD/jspanelForm.php?id=0&ROOT_PATH=D:/Development/1_Doctor/Development/BSP01&category=7
*/
session_start();
$_SESSION["ROOT_PATH"] = $_GET['ROOT_PATH'];
include_once($_SESSION["ROOT_PATH"] . '/config.php');
include_once($_SESSION["ROOT_PATH"] .  '/BSP/php/CRUD/jspanelLibrary.php');
include_once($_SESSION["ROOT_PATH"] . '/functions/mySQLFunctions.php');

global $conn;
$category = $_GET['category'];
$selectedId = $_GET['id'];
$mmm = $_SESSION["ROOT_PATH"];
$mmm = urlencode(utf8_encode($mmm));
$data = mySQLFunctions(9, array(
    $category,
    $selectedId,
    $conn
));

$someArray = json_decode($data, true);
/*var_dump($someArray); */

/*
foreach ($someArray["contents"] as $index=>$content) {
    $someArray["contents"][$index]['id']=$index;
}    
*/


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href=" <?php echo BASE_URL .  'vendors/bootstrap/dist/css/bootstrap.min.css'; ?> " rel="stylesheet">
    <!-- Font Awesome -->
    <link href=" <?php echo BASE_URL .  'vendors/font-awesome/css/font-awesome.min.css'; ?> " rel="stylesheet">
    <!-- NProgress -->
    <link href=" <?php echo BASE_URL .  'vendors/nprogress/nprogress.css'; ?> " rel="stylesheet">
    <!-- iCheck -->
    <link href=" <?php echo BASE_URL .  'vendors/iCheck/skins/flat/green.css'; ?> " rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href=" <?php echo BASE_URL .  'vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css'; ?> " rel="stylesheet">
    <!-- JQVMap -->
    <link href=" <?php echo BASE_URL . 'vendors/jqvmap/dist/jqvmap.min.css'; ?> " rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->

    <link href=" <?php echo BASE_URL .  'vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'; ?> " rel="stylesheet">

    <!-- Custom Theme Style -->
    <!-- TODO put back the minified version after completion and minification -->
    <link href=" <?php echo BASE_URL .   'build/css/custom.css'; ?> " rel="stylesheet">
    <link href=" <?php echo BASE_URL .   'build/css/style-extra-bs4.css'; ?> " rel="stylesheet">
    <!-- Datatables css BSP Addition-->
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.jqueryui.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.jqueryui.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/jspanel4@4.8.0/dist/jspanel.css" rel="stylesheet">
    <!-- custom jspanel  css -->
    <link href=" <?php echo BASE_URL .   'BSP/php/CRUD/custom.css'; ?> " rel="stylesheet">



</head>
<style>
    .form-control-feedback {
        margin-top: 4px;
        color: #020719e0;

        font-size: 15px;
    }

    .select2-hidden-accessible {
        border: 0 !important;
        color: red;
    }
</style>

<body>
    <div class="container">
        <!-- Master HTML -->
        <!-- onsubmit="return validateForm()" -->

        <form id="form" method="POST" autocomplete="off" action="myStoreFunctions.php?CategoryCRUD=0&myCategory=<?php echo $category ?>&MasterID=<?php echo $selectedId; ?> &PINmaster=<?php echo $someArray['PINmaster'];  ?>   " onsubmit="return validateForm(event)" class="form-horizontal form-label-left needs-validation" style="margin-top: 10px" novalidate enctype="multipart/form-data">

            <?php

            echo '<input type="text" hidden name = "Hotel_ID" id = "Hotel_ID" value  = "' . $_GET['WorkID'] . '"/>';

            if ($category == 2) {
                echo '<input type="text" hidden name = "PIN01P01" id = "PIN01P01" value  = "1"/>';
            } else if ($category == 5) {
                echo '<input type="text" hidden name = "Category" id = "Category" value  = "1"/>';
            } else if ($category == 6) {
                echo '<input type="text" hidden name = "Category" id = "Category" value  = "2"/>';
            }
            $myTab = "";
            if ((int) $someArray["tab-length"] == 0) {
                foreach ($someArray["contents"] as $content) {
                    $myTab .= textToDive($content, $_SESSION["BASE_URL"]);
                }
            } else {
                $myTab = "<ul id='myTab' class='col-md-12 nav nav-tabs bar_tabs' role='tablist'>";
                for ($myx = 0; $myx < count($someArray["tabs"]); $myx++) {
                    $myTabDetails = "<li role='presentation' class='nav-item' id='BSPXX01'><a href='#BSPtab_content' class='nav-link BSPactive' id='BSPP01' role='tab' data-toggle='tab' aria-expanded='false'>BSPDescription</a></li>";
                    if ($myx == 0) {
                        $myTabDetails = str_replace("BSPactive", "active", $myTabDetails);
                    } else {
                        $myTabDetails = str_replace("BSPactive", "", $myTabDetails);
                    }
                    $myTabDetails = str_replace("#BSPtab_content", "#tab_content" . ($myx + 1), $myTabDetails);
                    $myTabDetails = str_replace("BSPXX01", "XX0" . ($myx + 1), $myTabDetails);
                    $myTabDetails = str_replace("BSPP01", "P0"  . ($myx + 1), $myTabDetails);
                    $myTabDetails = str_replace("BSPDescription", $someArray["tabs"][$myx], $myTabDetails);
                    $myTab .= $myTabDetails;
                }
                $myTab .= "</ul>";
                $myTab .= "<div id='myTabContent' class='tab-content'>";
                $myD = 0;

                for ($myx = 0; $myx < count($someArray["tabs"]); $myx++) {
                    $myTabDetails = "<div role='tabpanel' class='tab-pane fade show BSPactive' id='BSPtab_content' aria-labelledby='BSPP0'>";
                    if ($myx == 0) {
                        $myTabDetails = str_replace("BSPactive", "active", $myTabDetails);
                    } else {
                        $myTabDetails = str_replace("BSPactive", "", $myTabDetails);
                    }
                    $myTabDetails = str_replace("BSPtab_content", "tab_content" . ($myx + 1), $myTabDetails);
                    $myTabDetails = str_replace("BSPP0", "P0"                   . ($myx + 1), $myTabDetails);
                    $myTab .= $myTabDetails;
                    foreach ($someArray["contents"] as $content) {
                        if ($content["tab"] == $myx + 1)    $myTab .= textToDive($content, $_SESSION["BASE_URL"]);
                    }
                    $myTab .= "</div>";
                }


                $myTab .= "</div>";
            }
            error_log("End  :" . $myTab);
            echo $myTab;

            /* Add info for SMS Templates */
            if ($_GET['category'] == 24) {
                echo "<p>Μήκος μηνύματος:<b><span id='SMS_Chars01'></span></b> χαρακτήρες <br><span style='color:red'>Credits:<b><span id='SMS_Chars02'></span></b></span></p>";
                echo "	<div class='row'  >
                                <p>Για λόγους ορθής χρήσης απο τις εταιρείες κινητής τηλεφωνίας, κάθε sms που υπερβαίνει τους 160 χαρακτήρες υπολογίζεται ως 2 ή περισσότερα sms και καταναλώνει 2 ή περισσότερα  credits αντίστοιχα. <br>
                                Μέγιστος αριθμός χαρακτήρων εχει οριστεί στους 612 χαρακτήρες και δεν μπορείτε να τους υπερβείτε.<br>
                                <b>Capital Only Yes</b> Ολοι οι ελληνικοί χαρακτήρες θα μετατραπούν σε κεφαλαία. Οι αγγλικοί θα παραμείνους ως εχουν<br>
                                <b>Capital Only No</b> Θα παραμείνει ο διαχωρισμός κεφαλαίων και πεζών/b>ιδικά για τους ελληνικούς χαρακτήρες τα μηνύματα μετατρέπονται αυτόματα σε κεφαλαία. Αν u;elete επιλέξετε UniCode, t;oy'και πεζούς χαρακτήρες' τότε κάθε χαρακτήρας
								<br>Υποστηρίζονται χαρακτήρες Πεζά,Κεφαλαία και ειδικοί χαρακτήρες μεχρι 612 χαρακτήρες σύνολικά <br>
								Στην πραγματικότητα αν γράψετε πάνω από 160 χαρακτήρες, αποστέλλονται 2 ή περισσότερα sms που ενώνονται στο κινητό του παραλήπτη και ο παραλήπτης βλέπει μόνο ένα, μεγαλύτερο σε μέγεθος sms
								</p>
							</div>
					";
            } else {
                echo "<br><br>";
            }
            ?>


            <footer class="page-footer  fixed-bottom bottom-margin bg-light">
                <div class="btn-toolbar d-flex flex-row-reverse" role="toolbar">
                    <input type="submit" id="btnSubmit" style="margin-right:10px; margin-bottom:4px; " class="btn btn-info" value='Save' />
                    <button type="button" id="btnCancel" style="margin-right:10px; margin-bottom:4px;" class="btn btn-default">Cancel</button>

                    <button type="button" id="myDeletekk" style="display: none" style="margin-right:10px; margin-bottom:4px;" class="btn btn-default"> </button>

                </div>
            </footer>

        </form>
    </div>

    <!-- jQuery -->
    <script src="<?php echo BASE_URL . "vendors/jquery/dist/jquery.js";     ?>"></script>
    <!-- Popper -->
    <script src="<?php echo BASE_URL . "vendors/popper/popper.min.js";          ?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo BASE_URL . "vendors/bootstrap/dist/js/bootstrap.min.js"; ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo BASE_URL . "vendors/fastclick/lib/fastclick.js";     ?>"></script>
    <!-- NProgress -->
    <script src="<?php echo BASE_URL . "vendors/nprogress/nprogress.js";     ?>"></script>
    <!-- Chart.js -->
    <script src="<?php echo BASE_URL . "vendors/Chart.js/dist/Chart.min.js";     ?>"></script>
    <!-- gauge.js -->
    <script src="<?php echo BASE_URL . "vendors/gauge.js/dist/gauge.min.js";     ?>"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo BASE_URL . "vendors/bootstrap-progressbar/bootstrap-progressbar.min.js";     ?>"></script>
    <!-- iCheck -->
    <script src="<?php echo BASE_URL . "vendors/iCheck/icheck.min.js";     ?>"></script>
    <!-- Skycons -->
    <script src="<?php echo BASE_URL . "vendors/skycons/skycons.js";     ?>"></script>
    <!-- Flot -->
    <script src="<?php echo BASE_URL . "vendors/Flot/jquery.flot.js";     ?>"></script>
    <script src="<?php echo BASE_URL . "vendors/Flot/jquery.flot.pie.js";     ?>"></script>
    <script src="<?php echo BASE_URL . "vendors/Flot/jquery.flot.time.js";     ?>"></script>
    <script src="<?php echo BASE_URL . "vendors/Flot/jquery.flot.stack.js";     ?>"></script>
    <script src="<?php echo BASE_URL . "vendors/Flot/jquery.flot.resize.js";     ?>"></script>
    <!-- Flot plugins -->
    <script src="<?php echo BASE_URL . "vendors/flot.orderbars/js/jquery.flot.orderBars.js";     ?>"></script>
    <script src="<?php echo BASE_URL . "vendors/flot-spline/js/jquery.flot.spline.min.js";     ?>"></script>
    <script src="<?php echo BASE_URL . "vendors/flot.curvedlines/curvedLines.js";     ?>"></script>
    <!-- DateJS -->
    <script src="<?php echo BASE_URL . "vendors/DateJS/build/date.js";     ?>"></script>
    <!-- JQVMap -->
    <script src="<?php echo BASE_URL . "vendors/jqvmap/dist/jquery.vmap.js";     ?>"></script>
    <script src="<?php echo BASE_URL . "vendors/jqvmap/dist/maps/jquery.vmap.world.js";     ?>"></script>
    <script src="<?php echo BASE_URL . "vendors/jqvmap/examples/js/jquery.vmap.sampledata.js";     ?>"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo BASE_URL . "vendors/moment/min/moment.min.js";     ?>"></script>
    <script src="<?php echo BASE_URL . "vendors/moment/locale/el.js";     ?>"></script>
    <script src="<?php echo BASE_URL . "vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js";     ?>"></script>

    <!-- Custom Theme Scripts -->
    <!--
            <script src="<?php echo BASE_URL . "build/js/custom.js";     ?>"></script>
            -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jspanel4@4.8.0/dist/jspanel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspanel4@4.8.0/dist/extensions/modal/jspanel.modal.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspanel4@4.8.0/dist/extensions/tooltip/jspanel.tooltip.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspanel4@4.8.0/dist/extensions/hint/jspanel.hint.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspanel4@4.8.0/dist/extensions/layout/jspanel.layout.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspanel4@4.8.0/dist/extensions/contextmenu/jspanel.contextmenu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspanel4@4.8.0/dist/extensions/dock/jspanel.dock.js"></script>





    <script src="<?php echo BASE_URL . "BSP/js/generic.js";     ?>"></script>

    <!-- custom jspanel  js -->
    <script src="<?php echo BASE_URL . "BSP/php/CRUD/custom.js";     ?>"></script>



    <script>
        function validateForm(e) {




            debugger;
            $(data1).each(function(index, obj) {
                if (obj.value === true) obj.value = "1";
                if (obj.value === false) obj.value = "0";
            });
            var data2 = $('form').serializeArray({
                checkboxesAsBools: true
            });
            $(data2).each(function(index, obj) {
                if (obj.value === true) obj.value = "1";
                if (obj.value === false) obj.value = "0";
            });
            jsonIn = JSON.stringify(data1);
            jsonOut = JSON.stringify(data2);
            jsonDesign = JSON.stringify(<?php echo $data ?>);
            $('<input type="hidden" name="jsonIn"/>').val(jsonIn).appendTo('form');
            $('<input type="hidden" name="jsonOut"/>').val(jsonOut).appendTo('form');
            $('<input type="hidden" name="jsonDesign"/>').val(jsonDesign).appendTo('form');
            $.ajax({
                type: "post",
                url: "<?php echo BASE_URL  ?>BSP/php/CRUD/validate.php",
                async: false,
                data: ({
                    CategoryCRUD: 4,
                    MasterID: <?php echo $selectedId ?>,
                    MasterTable: "<?php echo $someArray['PINmaster'] ?>",
                    jobCategory: "<?php echo $category ?>",
                    ROOT_PATH: "<?php echo urlencode(utf8_encode($_SESSION["ROOT_PATH"])) ?>",
                    jsonIn: jsonIn, //  JSON.stringify(data1),
                    jsonOut: jsonOut, //  JSON.stringify($('form').serializeArray({ checkboxesAsBools: true }))
                    jsonDesign: jsonDesign
                }),
                success: function(data) {
                    if (data == "") {
                        return true;
                    } else {
                        var str01 = data.split("|");
                        if (str01[0] == "errorDisplay") {

                            bsp_messageBox(str01[1], str01[2], 1);
                            e.preventDefault();

                            return false;
                        }
                        e.preventDefault();
                        return false;
                    }
                    return;
                },
                error: function(data) {
                    debugger;
                    alert("Error Validating Form");
                    return false;
                }
            });
        }
        $(document).ready(function() {
            myCategory = <?php echo $category ?>;
            if (myCategory == 1 || myCategory == 5 || myCategory == 6) {

                $('#btnNewFolder').css("display", "inline");

            }


            $('input[unique="1"]').change(function() {
                var thiss = $(this);

                $.ajax({
                    method: "POST",
                    url: "<?php echo BASE_URL ?>BSP/php/CRUD/duplicateFinder.php",
                    async: true,
                    data: {
                        name: $(this).attr('name'),
                        value: $(this).val(),
                        pin: "<?php echo $someArray['PINmaster'] ?>",

                    },

                    success: function(response) {


                        if (response.count > 0) {
                            $(thiss).css('border-color', 'red');
                            $("#btnSubmit").prop("disabled", true);
                            return;
                        } else {
                            $('#btnSubmit').prop("disabled", false);
                            $(thiss).css('border-color', '');
                        }
                    },

                });
            });


            var jsonIn;
            var jsonOut;
            var myCategory = "<?php echo $_GET['category'] ?>";
            if (myCategory == 24) {
                var val01 = encodeURI($("#2").val()).split(/%..|./).length - 1;
                var val02 = Math.ceil(val01 / 160);
                //val01=encodeURIComponent($("#2").val()).match(/%[89ABab]/1);

                $("#SMS_Chars01").html(val01);
                $("#SMS_Chars02").html(val02);
            }
            $('[Group=2]').insertAfter($('[Group=1]')[0]);
            var selectTags = $('.selection-field').find("option:first-child").val();
            if ($('.selection-field').val() == selectTags) {
                $('[Group=2]').toggle();
            } else {
                $('[Group=1]').toggle();
            }
            $("#2").on('input', function(e) {
                if (myCategory == 24) {
                    var val01 = this.value.length;
                    var val02 = Math.ceil(val01 / 160);
                    $("#SMS_Chars01").html(val01);
                    $("#SMS_Chars02").html(val02);

                }

            });

            $("#myDeletekk").on('click', function(event, json, string) {
                if (string == 'selectionYes') {

                    $.ajax({
                        type: "post",
                        url: "<?php echo $_SESSION['BASE_URL'] ?>functions/genericCall.php",
                        async: false,
                        data: ({
                            CategoryAction: myCategory,
                            Description: json.data[2],
                            workID: localStorage.getItem("WorkID")

                        }),
                        success: function(data) {
                            //var data = {id: 20, text: 'ΠΑΝΑΓΟΣ ΓΕΩΡΓΙΟΣ'};
                            var data = {
                                id: data.LastID,
                                text: json.data[2]
                            };
                            var newOption = new Option(data.text, data.id, false, true);
                            if (myCategory == 6 || myCategory == 5) {
                                $("form select[name='room_category_ID']").append(newOption).trigger('change');

                            } else
                                $("form select[name='PIN02P02']").append(newOption).trigger('change');

                            //$("form select[name='PIN60P18']").select2('data',{id: data.LastID, text:"fsdfdsf"   }); 
                            //$("form select[name='PIN60P18']").val(data.LastID).trigger("change"); 
                            //alert( obj[0][Object.keys(obj[0])[0]]);
                        }
                    });
                }
                myjsPanel2.close();
            });

            $('#btnNewFolder').click(function() {

                myjsPanel2 = bsp_messageBox("Create new Group category", "&nbsp; Group category's name:      <input type='text' style='margin-left:10px;margin-right:10px' class='form-control form-control-sm' id='myInput'    title='Ονομασία Υποφακέλλου που θα προστεθεί'>", 7, 0, "", 2, 4, "myInput");
            });

            $('.selection-field').on('change', function() {
                if (this.value == selectTags) {

                    $('[Group=2]').toggle();
                    $('[Group=1]').toggle();


                } else {
                    $('[Group=1]').toggle();
                    $('[Group=2]').toggle();

                }

            });
            $(".myCombo").select2({

                width: '100%',
                dropdownAutoWidth: 'true',
                theme: 'classic',
                ajax: {
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function(data, params) {

                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                // escapeMarkup: function (markup) { return markup; }, // let our custom formatter work

                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo(repo) {
                if (repo.loading) return repo.text;
                return repo.desc;
            }

            function formatRepoSelection(repo) {
                return repo.desc || repo.text;
            }
            $('form').ready(function() {
                data1 = $('form').serializeArray({
                    checkboxesAsBools: true
                });
                /*j1 = {};
                $(data1).each(function(index, obj) {
                    j1[obj.name] = obj.value;

                });*/

            });
            $('form').submit(function(e) {
                //var data = JSON.stringify(j1)
                //$('<input type="hidden" name="json"/>').val(data).appendTo('form');
                /* Validation Rules */
                /* return false */


            });
            $('#btnCancel').click(function() {

                window.parent.$('#myDeletekk').trigger('click');
            });


            (function($) {
                $.fn.serialize = function(options) {
                    return $.param(this.serializeArray(options));
                };

                $.fn.serializeArray = function(options) {
                    var o = $.extend({
                        checkboxesAsBools: false
                    }, options || {});

                    var rselectTextarea = /select|textarea/i;
                    var rinput = /text|hidden|password|search|number/i;

                    return this.map(function() {
                            return this.elements ? $.makeArray(this.elements) : this;
                        })
                        .filter(function() {
                            return this.name && !this.disabled &&
                                (this.checked ||
                                    (o.checkboxesAsBools && this.type === 'checkbox') ||
                                    rselectTextarea.test(this.nodeName) ||
                                    rinput.test(this.type));
                        })
                        .map(function(i, elem) {
                            var val = $(this).val();
                            return val == null ?
                                null :
                                $.isArray(val) ?
                                $.map(val, function(val, i) {
                                    return {
                                        name: elem.name,
                                        value: val
                                    };
                                }) : {
                                    name: elem.name,
                                    value: (o.checkboxesAsBools && this.type === 'checkbox') ?
                                        (this.checked ? true : false) : val
                                };
                        }).get();
                };
            })(jQuery);
        });
    </script>

</body>


</html>