<style type="text/css">
    code {
        padding: 0.5em;
        border: 1px dashed #2f6fab;
        color: black;
        background-color: #f9f9f9;
        line-height: 1.1em;
    }
</style>
<a href="#pdf_options_list-body" data-toggle="collapse"
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3
            mt-4
            border bg-light mb-0 h6 text-decoration-none">
    {{ __('Option List') }}
</a>

<div class="card-body collapse show border border-top-0 p-2" id="pdf_options_list-body">
    <table class="pdfs table table-striped table-bordered">
        <thead class="thead-dark">
        <tr id="heading">
            <th class="pdfs"><?php echo __('Name')?></th>
            <th class="pdfs"><?php echo __('Value');?></th>
            <th class="pdfs"><?php echo __('Description');?></th>
            <th class="pdfs"><?php echo __('OTP');?></th>
            <th class="pdfs"><?php echo __('Designer');?></th>
            <th class="pdfs"><?php echo __('Formular');?></th>
        </tr>
        </thead>
        <tbody>
        <tr class="gridshadow">
            <td>MaxLength</td>

            <td>Numeric</td>
            <td><?php echo __('Maximul length allowed for input value');?></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Copy</td>

            <td><?php echo __('Name of Block to copy')?></td>
            <td><?php echo __('Copy value from different block')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>FormatRule</td>

            <td><p><?php echo __('PHP format rule example')?>:</p><code>return str_replace(' ', '', $value);</code></td>
            <td><?php echo __('Formating rule for user input')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>ValidationRule</td>

            <td><p><?php echo __('PHP validation rule example')?>:</p><code>return (strpos($value, '.com') !== false);</code></td>
            <td><?php echo __('Validation rule for user input')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Required</td>

            <td>0 / 1</td>
            <td><?php echo __('User input required')?></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Visible</td>

            <td>0 / 1</td>
            <td><?php echo __('Field visibility')?></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>SelectBox</td>

            <td>0 / 1</td>
            <td><?php echo __('Select box will be shown instead of input.')?></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Suffix</td>

            <td>String</td>
            <td><?php echo __('Suffix for the block.')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Prefix</td>

            <td>String</td>
            <td><?php echo __('Prefix for the block.')?></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Group</td>

            <td>String</td>
            <td><?php echo __('Name of the group that current block is a part of.')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Depend</td>

            <td><?php echo __('Block name')?></td>
            <td><?php echo __('Name of the block that current block is a dependent on.')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Concat</td>

            <td><?php echo __('Block name')?></td>
            <td><?php echo __('Name of the block that current block is going to be concatenated with.')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>ConcatBefore</td>

            <td><?php echo __('Block name')?></td>
            <td><?php echo __('Name of the block that current block is going to be concatenated with before.')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>ConcatAfter</td>

            <td><?php echo __('Block name')?></td>
            <td><?php echo __('Name of the block that current block is going to be concatenated with after.')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Freeze</td>

            <td><?php echo __('Block name')?></td>
            <td><?php echo __("Current block will no longer change it's position.")?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>BeforeInputField</td>

            <td>String</td>
            <td><?php echo __('String will be added before input field.')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>AfterInputField</td>

            <td>String</td>
            <td><?php echo __('String will be added after input field.')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>QR</td>

            <td>0 / 1</td>
            <td><?php echo __('Enable / Disable QR.')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>QRSource</td>

            <td><?php echo __('Block name')?></td>
            <td><?php echo __('If you create a PDF with a block type Image, and put custom options QR = 1, QRSource = Block_1;Block_2 etc, those blocks will be created of type textline. In personalization template, the first block with QR and QRSource will not appear, only the other ones. When you press "Preview" an QR image will be created with the information gathered from QRSource blocks. If one or all the fields are left empty, than a QR image with no information will be created.')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>QRColor</td>

            <td>String</td>
            <td><?php echo __('RGB color of QR image. It uses hex color codes but without using the "#" before the code. e.g QRColor=787432')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>QRCorrection</td>

            <td>L/M/Q/H</td>
            <td><?php echo __('Correction level for QR image')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>HideLineUp</td>

            <td>0 / 1</td>
            <td><?php echo __('Enable / Disable HideLineUp.');?></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>HideLineUpTarget</td>

            <td><?php echo __('Block name')?></td>
            <td><?php echo __('Only Block_1,Block_2,etc will be affected by the line up functioanlity.')?></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>HideLineDown</td>

            <td>0 / 1</td>
            <td><?php echo __('Enable / Disable HideLineDown.')?></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>HideLineDownTarget</td>

            <td><?php echo __('Block name')?></td>
            <td><?php echo __('Only Block_1,Block_2,etc will be affected by the line down functioanlity.')?></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>CustomDepend</td>

            <td width="465px"><code>return (!strlen($data['Block_1']) && !strlen($data['Block_2']));</code></td>
            <td><?php echo __('The current block where CustomDepend is added will be hidden if the condition set here is true.');?></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>ProjectName</td>

            <td>String</td>
            <td><?php echo __('Set the name of the project.')?></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
        </tr>

        <tr class="gridshadow">
            <td>Circle</td>

            <td>0 / 1</td>
            <td><?php echo __('Change current block shape to a circle. Also, the block must be a square.')?></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>Editable</td>

            <td>0 / 1</td>
            <td><?php echo __('Editable from editor.')?></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>Opacity</td>

            <td>values between 0.00 - 1.00</td>
            <td><?php echo __('Set block opacity.')?></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>Movable</td>

            <td>0 / 1</td>
            <td><?php echo __('Allow block to be movable.');?></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>Resizable</td>

            <td>0 / 1</td>
            <td><?php echo __('it allows the block to be resized. 1 - allows block resize,  0 -  doesn`t allow block resize')?></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>Rotatable</td>

            <td>0 / 1</td>
            <td><?php echo __('it allows the block to be rotatable. 1 - allows block rotation, 0 -  doesn`t allow block rotation')?></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>BackgroundBlock</td>

            <td>0 / 1</td>
            <td><?php echo __('OTP editor. it has to be an image type block and to cover the entire template, this allows customer to add a template background color (currently it works only with an image upload, no color is here to be defined or choosable form a color pallete)')?></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>IsTable</td>

            <td><?php echo __('Table id from backend');?></td>
            <td><?php echo __('OTP editor. Table creation block')?></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>QRCorrectionMargin</td>

            <td>0 / 1</td>
            <td> Enable / Disable a white margin for QR code.</td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>OnTop</td>

            <td>0 / 1</td>
            <td><?php echo __('The current block where OnTop is added will be in front of all the other blocks.')?></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>AlternateZoom</td>

            <td>0 / 1</td>
            <td><?php echo __('Allows the image to be fully displayed in the block. Specifically used for Logos.');?> </td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>

        <tr class="gridshadow">
            <td>CircleText</td>

            <td>0 / 1</td>
            <td><?php echo __('Allows customer to add circle text on the template. Usually, this block is created outside the template.')?>  </td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>CircleTextPosition</td>

            <td>0 / 1</td>
            <td><?php echo __(' Allows customer to add text in the circle text block. 0 - the text is added clockwise, 1 - the text is added counter clockwise.')?>  </td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
        </tr>
        <tr class="gridshadow">
            <td>IgnoreOnRest</td>

            <td>0 / 1</td>
            <td><?php echo __('The block is shown in editor, but not in the final pdf.')?></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"/></td>
        </tr>

        <tr class="gridshadow">
            <td>DefaultImage</td>

            <td><?php echo __('Code of the image from local images')?></td>
            <td><?php echo __('Default value for the input.')?> </td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>

        <tr class="gridshadow">
            <td>FitFont</td>

            <td>0 / 1</td>
            <td><?php echo __('Fit font size in block dimmensions in desinger')?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>ArticleId</td>

            <td><?php echo __('Id of article.')?></td>
            <td> <?php echo __('Article load id')?></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>FormatRuleFrontend</td>

            <td>0 / 1</td>
            <td>  <?php echo __('Define javascript format rule') ?></td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>IndesignName</td>

            <td>String</td>
            <td><?php echo __('Define alias name used for connected text boxes') ?>  </td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>NextTextFrame</td>

            <td>String</td>
            <td><?php echo __('Define next connected box by Indesign Name') ?>  </td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>PreviousTextFrame</td>

            <td>String</td>
            <td><?php echo __('Define previous connected box by Indesign Name') ?>  </td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Translatable</td>

            <td>0 / 1</td>
            <td><?php echo __('Define if the text for block is translatable in frontend') ?>  </td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>

        <tr class="gridshadow">
            <td>QRCMYKFColor</td>

            <td>String</td>
            <td><?php echo __('Define CMYK value for foreground') ?>  </td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>QRCMYKBColor</td>

            <td>String</td>
            <td><?php echo __('Define CMYK value for border') ?>  </td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
        </tr>

        <tr class="gridshadow">
            <td>Helper</td>

            <td>0 / 1</td>
            <td>Designer helper block (the block will be visible only on editor,on top and not selectable)</td>
            <td class="opt"><span class="ion-close-circled"/></td>
            <td class="opt"><span class="ion-checkmark-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"/></td>
        </tr>
        <tr class="gridshadow">
            <td>Template</td>

            <td>0 / 1</td>
            <td><?php echo __('Define the template block used as template for new added blocks') ?></td>
            <td class="opt"><span class="ion-checkmark-circled"/></td>
            <td class="opt"><span class="ion-close-circled"></span></td>
            <td class="opt"><span class="ion-close-circled"/></td>
        </tr>
        </tbody>
    </table>
</div>

<style>
    /*#heading {
        background-color: #3c8dbc;
    }*/

    span.ion-checkmark-circled {
        font-size: 20px;
        color: #15ca15;
    }

    span.ion-close-circled {
        font-size: 20px;
        color: #ca1515;
    }

    td.opt {
        text-align: center;
    }
</style>
