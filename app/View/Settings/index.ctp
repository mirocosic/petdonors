// <script>
    
var settings = new Ext.panel.Panel({
    title: '<?=__("Settings");?>',
    items:[{
        xtype:'container',
        layout:'hbox',
        items:[
            {
            xtype:'container',
            html:'<?=__("Language");?>:',
            margin: '10 10 10 10'
            },{
                xtype: 'segmentedbutton',
                margin: '5 5 5 5',
                items: [{
                    text: 'Hrvatski',
                    pressed: <?php if($this->Session->read('Config.language') == 'hrv'){ echo 'true';} else {echo 'false';}?>,
                    handler: function(){
                        window.location.href='<?=$this->Html->url(array('language'=>'hrv'));?>';
                    }
                }, {
                    text: 'English',
                    pressed: <?php if($this->Session->read('Config.language') == 'eng'){ echo 'true';} else {echo 'false';}?>,
                    handler: function(){
                        window.location.href='<?=$this->Html->url(array('language'=>'eng'));?>';
                    }
                }]
            }]
        }]
});