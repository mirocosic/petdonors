<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        <div class="col-lg-4 col-md-6 col-sm-8 col-xs-10">
            
             <?php echo $this->Form->create('Donor', array('url'=>array('controller'=>'Donors', 'action' => 'signup'),'class'=>'form-signin')); ?>
            <h3 class="form-signin-heading text-center"><?=__('Donor signup');?></h3>
                <div class="form-group">
                     
                    <?php 
                    echo $this->Form->input('name', ['class'=>'form-control','placeholder'=>__("Name"),'label'=>false]);
                    echo $this->Form->input('address', ['class'=>'form-control','placeholder'=>__("Address"),'label'=>false]);
                    echo $this->Form->input('city', ['class'=>'form-control','placeholder'=>__("City"),'label'=>false]);
                    //echo $this->Form->input('date_of_birth', ['class'=>'form-control','placeholder'=>__("Date of birth"),'label'=>false]);
                    //echo $this->Form->input('gender', ['class'=>'form-control','placeholder'=>__("Gender"),'label'=>false]);
                   
                    echo $this->Form->input('contact_name', ['class'=>'form-control','placeholder'=>__("Contact name"),'label'=>false]);
                    echo $this->Form->input('contact_number', ['class'=>'form-control','placeholder'=>__("Contact number"),'label'=>false]);
                    echo $this->Form->input('contact_mail', ['class'=>'form-control','placeholder'=>__("Contact mail"),'label'=>false]);
                    echo $this->Form->input('weight', ['class'=>'form-control','placeholder'=>__("Weight").' (kg)','label'=>false]);
                    //echo $this->Form->input('gender', ['class'=>'form-control','placeholder'=>__("Gender"),'label'=>false]);
                       
                    ?>
                </div>
            <div class="col-xs-6 text-center"><button class="btn btn-lg btn-info btn-block" type="submit"><?=__("Submit");?></button></div>
            <?php echo $this->Session->flash(); ?>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
    </div>
</div>
