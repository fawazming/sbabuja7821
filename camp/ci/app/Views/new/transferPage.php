<div class="col-lg-6 d-flex flex-column content-right">
    <div class="container my-auto py-5">
        <div class="row mb-5">
            <div class="col-12">
                <a href="<?=base_url('/')?>"><button type="button" class="forward">Home</button></a>
            </div>
        </div>
        <div class="row"><br><br>
            <h5>Get your Pin Directly</h5>
            <div class="container">
                <div class="" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                    <div class="mb-3 row" style="align-items: center;">
                        <p>Kindly transfer a sum of N8060 to the bank details below:</p>
                        <p>BANK: <?=$payment->bankName?></p>
                        <p>ACC Number: <?=$payment->accountNumber?></p>
                        <p>ACC Name: <?=$payment->accountName?></p>
                    </div>
                    <div class="mb-3 row">
                        <div class="text-center">
                            <a href="" class="btn btn-primary">I have made the transfer</a>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <div class="container copy">
        <span class="float-start">© SB HIC</span>
        <a class="btn_help float-end" href="https://wa.me/+2348108097322" target="_blank"><i
                class="bi bi-question-circle"></i>Help</a>
        <a class="btn_help float-end" href="#modal-pStatus" id="modal_p"><i class="bi bi-question-circle"></i>Pin Status
            &nbsp; &nbsp; &nbsp;</a>
        <br>
    </div>
    <center style="margin-top: 0px;">Designed with ❤️ by <a href="https://rayyantech.sgm.ng">Rayyan Technologies</a>
    </center>

</div>