        <?php

        function textToDive($content, $path)
        {
            /*
*   switch of datatype
*   @param   dataType
*   $targets represent some specific attributes of each field
*   $sources represent the values of those fileds
* ".js-example-theme-single"
*/
            if ($content["readonly"] == '')   $content["readonly"] = 0;
            if ($content["required"] == '')   $content["required"] = 0;
            $myConverter4 = array(0 => '', 1 => 'readonly', null => '');
            $readOnly = $myConverter4[$content["readonly"]];

            $myConverter2 = array(0 => '', 1 => 'required');
            $required = $myConverter2[$content["required"]];

            if ($content['uniq'] == '') $content['uniq'] = 0;
            $myConverter2 = array(0 => '', 1 => '1');
            $unique = $myConverter2[$content["uniq"]];

            $res = "";
            if (is_null($content['Originalvalue'])) $content['Originalvalue'] = "";
            switch ((int) $content["dataType"]) {
                case 1:     /*text*/
                    $res = '
            <div class="form-group row" group="' . $content["Group"] . '"> 
                    <label class="control-label col-md-3 col-sm-3 col-12">' . $content["label"] . '</label>
                    <div class="col-md-9 col-sm-9 col-12">
                        <input  type="text" autocomplete="off" name = "' . $content['nameField'] . '" class="form-control form-control-sm" id="' . $content['id'] . '" value="' . $content['Originalvalue'] . '" title="' . $content['tooltip'] . ' "unique = "' . $unique . '">   
                        <div class="invalid-feedback">
                            invalidMessageValue 
                        </div>
                    </div>         
            </div>';
                    break;
                case 3: /* date  format DD/MM/YYYY */
                    if ($content['Originalvalue'] == "") {
                        $myVal = "";
                    } else {
                        $myVal = date_create($content['Originalvalue']);
                        $myVal = date_format($myVal, "d/m/Y");
                    }

                    $res = '
            <div class="form-group-sm row"  group="' . $content["Group"] . '">
                <label class="control-label col-md-3 col-sm-3 col-12">' . $content["label"] . '</label>
                <div class="col-md-9 col-sm-9 col-12"> 
                     <input type="text" name = "' . $content['nameField'] . '" class="form-control form-control-sm has-feedback-left calendar-picker" aria-describedby="inputSuccess2Status3"  id="' . $content['id'] . '" value="' . $myVal  . '" title="' . $content['tooltip'] . '" ' . $required . ' ' . $readOnly . ' >
                    <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                    <span id="inputSuccess2Status3" class="sr-only">(success)</span> 
                 </div> 
            </div>';
                    break;
                case 9: /* password */
                    $res = '
            <div class="form-group row"  group="' . $content["Group"] . '">     
                <label class="control-label col-md-3 col-sm-3 col-12">' . $content["label"] . '</label>
                <div class="col-md-9 col-sm-9 col-12">
                    <input type="password" autocomplete="off" name = "' . $content['nameField'] . '" class="form-control form-control-sm" id="' . $content['id'] . '" value="' . $content['Originalvalue'] . '"title="' . $content['tooltip'] . '" ' . $required . ' ' . $readOnly . ' >
                    <div class="invalid-feedback">
                        invalidMessageValue 
                    </div>
                </div>
            </div>';
                    break;
                case 4: /* email */
                    $res = '
            <div class="form-group row"  group="' . $content["Group"] . '">
                <label class="control-label col-md-3 col-sm-3 col-12">' . $content["label"] . '</label>
                <div class="col-md-9 col-sm-9 col-12">
                    <input type="email" autocomplete="off" name = "' . $content['nameField'] . ' "unique = "' . $unique . '" class="form-control form-control-sm" id="' . $content['id'] . '" value="' . $content['Originalvalue'] . '"title="' . $content['tooltip'] . '" ' . $required . ' ' . $readOnly . ' >
                    <div class="invalid-feedback">
                        invalidMessageValue 
                    </div>
                </div>
            </div>';
                    break;
                case 5: /* Text area */
                    $res = '
            <div class="form-group row"  group="' . $content["Group"] . '"> 
                <label class="control-label col-md-3 col-sm-3 col-12">' . $content["label"] . '</label>
                <div class="col-md-9 col-sm-9 col-12">
                    <textarea name = "' . $content['nameField'] . '" class="form-control form-control-sm"  rows="3" id="' . $content['id'] . '"title="' . $content['tooltip'] . '" ' . $required . ' ' . $readOnly . ' >' . $content['Originalvalue'] . '</textarea>
                    <div class="invalid-feedback">
                        invalidMessageValue 
                    </div>
                </div>
             </div>';
                    break;
                case 2: /* checked */
                    $myConverter3 = array(0 => '', 1 => 'checked', null => '');
                    $checked = $myConverter3[$content["Originalvalue"]];
                    $res = '
            <div class="form-group row"  group="' . $content["Group"] . '">
                <label class="control-label col-md-3 col-sm-3 col-12">' . $content["label"] . '</label>
                <div class="col-md-9 col-sm-9 col-12" >
                    <input type="checkbox" name = "' . $content['nameField'] . '" class="flat" id="' . $content['id'] . ' "  ' .  $checked . ' title="' . $content['tooltip'] . '" ' . $required . ' ' . $readOnly . '>
                    <div class="invalid-feedback">
                        invalidMessageValue
                    </div>
                </div>
            </div>';

                    break;
                case 8:         /* Select 2 */
                    $res = '
            <div class="form-group row"   group="' . $content["Group"] . '">
                <label class="control-label col-md-3 col-sm-3 col-12"  id="l' . $content['id'] . '"  >' . $content["label"] . '</label>
                <div class="col-md-9 col-sm-9 col-12">
                <select  name = "' . $content['nameField'] . '" id="' . $content['id'] . '"  '
                        . ' title="' . $content['tooltip'] . '" ' . $required . ' ' . $readOnly
                        . 'class="form-control form-control-sm myCombo" data-ajax--url="' . $path . '/functions/myAjax.php?MyWay=4&amp;mySQL=' . $content['listData'] . '">
                <option value="' . $content['Originalvalue'] . '"  selected="selected" >' . $content['displayValue'] . '</option>   
                </select><button  id="btnNewFolder"   type="button" title="Create Group " style="display:none; float:right;margin-right:-35px" class="btn btn-info btn-sm"><span class="fa fa-plus-square"></span></button>
                </div>
            </div>';
                    break;
                case 7:         /* Fix Values */

                    $options = str_replace("'", chr(34), $content["listData"]);
                    $options = json_decode($options);
                    $res = '
            <div class="form-group row"  group="' . $content["Group"] . '">
                 <label id = "demo" class=" control-label col-md-3 col-sm-3 col-12">' . $content["label"] . '</label>
                    <div class="col-md-9 col-sm-9 col-12  ">
                    <select  name = "' . $content['nameField'] . '"  id="' . $content['id'] . ' "  ' .  $content['Originalvalue'] . ' title="' . $content['tooltip'] . '" ' . $required . ' ' . $readOnly . '  class="form-control form-control-sm selection-field">';
                    foreach ($options as $mykey => $option) {

                        if ($content["Originalvalue"] == $mykey) {
                            $res .= '<option value=' . $mykey . ' selected >' . $option . '</option>';
                        } else {
                            $res .=  '<option value=' . $mykey . ' >' . $option . '</option>';
                        }
                    }
                    $res .= '</select>
                </div>
            </div>';
                    break;
                case 10:    /* File System */
                    $res = '
                <div class="form-group row " group="' . $content["Group"] . '"> 
                    <label class="control-label col-md-3 col-sm-3 col-12">' . $content["label"] . '</label>
                    <div class="col-md-9 col-sm-9 col-12">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                      <p id="FileInfo"></p>
                    </div>         
            </div>';
                    break;


                case 11: /* checked  inline*/
                    $myConverter3 = array(0 => '', 1 => 'checked', null => '');
                    $checked = $myConverter3[$content["Originalvalue"]];
                    $res = '
                <div class="form-check form-check-inline"  group="' . $content["Group"] . '">
              <div class = "col-md-2">
                <label class="control-label col-md-1">' . $content["label"] . '</label>
                    <div class="col-md-1" >
                        <input type="checkbox" name = "' . $content['nameField'] . '" class="flat" id="' . $content['id'] . ' "  ' .  $checked . ' title="' . $content['tooltip'] . '" ' . $required . ' ' . $readOnly . '>
                        <div class="invalid-feedback">
                            invalidMessageValue
                        </div>
                    </div>
                    </div>
                </div>';

                    break;
            }
            return $res;
        }


        $tabPane = '<div class="tab-pane fade" id="#" role="tabpanel" aria-labelledby="nav-profile-tab">';



        $tab =
            '<li class="nav-item">
     <a class="nav-link " data-toggle="tab" href="#" role="tab">tabName</a>
</li>';
