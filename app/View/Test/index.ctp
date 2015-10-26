<script>
    Ext.application({
        name   : 'SmartSport',
        launch : function() {
            Ext.create('Ext.Panel', {
                renderTo     : Ext.getBody(),
                width        : 200,
                height       : 150,
                bodyPadding  : 5,
                title        : '<?=__("Hello World");?>',
                html         : 'This is Ext.Panel from ExtJS 6 - Triton theme'
            });
        }
    });
</script>