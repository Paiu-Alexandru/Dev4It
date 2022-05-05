<?php
include_once "layout/header.php";

use Controller\ValidateBookController;

$check = new ValidateBookController($_POST);
$gender = $check->takeGender();


if (isset($_POST['submit'])) {
     $check->validate();
    if (empty($check->error)) {
       $check->insertBook();
    }
}

$error = $check->error;
?>

<!--  style="border:1px solid black;"-->
<div class="container mt-5 ">


    <div class="row justify-content-md-center">
        <div class="col-md-6 col-lg-5 p-2 shadow-lg p-3 mb-5 bg-body rounded">
        <h3>Insert new Book</h3>
       
        <?php if($check->success): ?>
            <div class="alert alert-success" role="alert">
                 <p class="mb-0">Success!</p>
             </div>
            <?php endif; ?>

            <?php if($check->errorInsert): ?>
            <div class="alert alert-danger" role="alert">
                 <p class="mb-0">Error!</p>
             </div>
            <?php endif; ?>

        <form method="POST" action="">
            <div class="m-3">
                
                <input type="text" name="name" value="<?php echo $check->oldData('name') ?>" class="form-control " placeholder="Book Name">
                <div class="form-text text-danger"><?php echo $error['name'] ?? '';?></div>
            </div>
            <div class="m-3">
                <select name="gender" class="form-select" aria-label="Default select example">
                    <option value="">Gender selection..</option>
                    <?php
                        foreach ($gender as $option) {
                          $selected = ($check->oldData('gender') === $option['id'] ) ? 'selected': null;
                            echo '<option value="'.$option['id'].'" '.$selected.'>'.$option['gender'].'</option>';
                        }

                    ?>
                    
                </select>
                <div class="form-text text-danger"><?php echo $error['gender'] ?? '';?></div>
            </div>
            <div class="m-3">
                <input type="text" name="page_number" value="<?php echo $check->oldData('page_number')?>" class="form-control" placeholder="Number of pages" >
                <div class="form-text text-danger"><?php echo $error['page_number'] ?? '';?></div>
            </div>
            <div class="m-3">
                <select name="payment" class="form-select" id="payment_select">
                    <option value="default" >Select amount</option>
                    <option value="free" <?= $check->oldData('payment') === 'free' ? 'selected' : ''; ?>>For free</option>
                    <option value="other" <?= $check->oldData('payment') === 'other' ? 'selected' : ''; ?><?php echo $selected ?>>Insert amount</option>      

                </select>
                <div class="form-text text-danger"><?php echo $error['payment'] ?? '';?></div>
                <div id="otherBox" class="my-3">
                <div class="form-text text-success"><?php echo $error['price'] ?? '';?></div>

                    <input class="form-control "  name="price" value="<?php echo $check->oldData('price')?>" type="text" placeholder="Insert price 00.00" disabled id="input"> 
                </div>
                
            </div>
              
            <div class="mx-3 mb-3">
                <button type="submit" name="submit" class=" form-control btn btn-primary" >Submit</button>
            </div>

            
        </form>
        </div>
    
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){      
        if($('select[name="payment"] option:selected').val() !== 'free') {         
        $('input[name="price"]').attr('disabled', false);     
    } })



    $(document).on('change', '#payment_select', function(){
        const shouldEnable = $(this).val() !== 'other';
        $('#input').prop('disabled', shouldEnable);
    });
</script>

<?php
include_once "layout/footer.php";
?>