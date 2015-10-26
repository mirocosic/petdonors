<?php echo $this->Form->create('Group'); ?>
    <fieldset>
        <h3 class="form-signin-heading text-center"><?=__('Add group');?></h3>
        <div class="form-group">
            
        <?php 
            echo $this->Form->input('name', ['class'=>'form-control','placeholder'=>__('Name'),'label'=>__('Name')]);
        ?>
        </div>
        <?= $this->Form->submit(__('Create'));?>
        <?php echo $this->Session->flash(); ?>
    </fieldset>