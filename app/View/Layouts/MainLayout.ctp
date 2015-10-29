<!DOCTYPE html>
<html>
    <head>
        <title>PetDonors.org</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- load ExtJS -->
        <script src="/js/ext/ext-all.js"></script>
        
        <!-- load External plugins / libraries -->
        <script src="/js/ext.ux/GMapPanel.js"></script>
       <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
        
        <!-- load Theme Triton -->
        <script src="/ext-themes/theme-triton/theme-triton.js"></script>
        <link rel="stylesheet" href="/ext-themes/theme-triton/resources/theme-triton-all.css"/>
        
        <!-- load fonts -->
        <link rel="stylesheet" href="/css/fonts.css"/>
        
        <!-- load custom css overrides -->
        <link rel="stylesheet" href="/css/styles.css"/>
        
        
        
    </head>
    <body>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            <?php 
            /*
              $uid = AuthComponent::user('id');
              if ($uid){
                 //echo "ga('set', '&uid', 'UserID=$uid'); ";// Set the user ID using signed-in user_id.
                 echo "ga('create', 'UA-67040802-1', { 'userId': 'UserID=$uid' });";
                 echo "ga('send', 'pageview');";
              } else {
                  echo "ga('create', 'UA-67040802-1', 'auto');";
                  echo "ga('send', 'pageview');";
              }
             * 
             */
            ?>

        </script>
    </body>
    
    <!-- load ext modules 
    <?= $this->Html->script('/Modules/get/Users');?>
    <?= $this->Html->script('/Modules/get/Clinics');?>
    <?= $this->Html->script('/Modules/get/Permissions');?>
    <?= $this->Html->script('/Modules/get/Competitions');?>
    <?= $this->Html->script('/Modules/get/Events');?>
    <?= $this->Html->script('/Modules/get/Alliances');?>
    <?= $this->Html->script('/Modules/get/Donors');?>
    -->
   <script type='text/javascript'>
    Ext.require([
       
       // 'Ext.ux.GMapPanel'
    ]);
Ext.onReady(function() {
    
    Ext.define('Test', {
        extend: 'Ext.data.Model',
        fields: [{
            name: 'text',
            type: 'string'
        }],
        proxy: {
            type: 'memory',
            data: {
                success: true,
                children: [
                {
                    text: '<?=__("Home");?>',
                    glyph: 'xf1e3@FontAwesome',
                    iconCls: 'fa-building',
                    leaf: false, // this is a branch   
                    expanded: false,
                    children: [{
                        text: 'Mercedes-Benz',
                        leaf: true // this is a leaf node. It can't have children. Sad! :-(   
                    }, {
                        text: 'Audi',
                        leaf: true
                    }, {
                        text: 'Ferrari',
                        
                        leaf: true
                    }]
                },{
                    text:'<?=__('Actions');?>',
                    iconCls:'fa-flash',
                    expanded:false,
                    leaf:false,
                    href:'/events'
                },{
                    text:'<?=__('Donors');?>',
                    
                    iconCls: 'fa-tint',
                    expanded:false,
                    leaf:false,
                    href:'/donors',
                    children: [{
                        text: '<?=__('Search');?>',
                        iconCls:'fa-search',
                        leaf: true,
                        href:'/donors'
                    }, {
                        text: '<?=__('New');?>',
                        iconCls:'fa-plus',
                        leaf: true
                    }]
                    
                },{
                   text: '<?=__("Clinics");?>',
                   iconCls:'fa-hospital',
                   href:'/clinics',
                   leaf: false,
                   expanded: false,
                },{
                   text: '<?=__("Vets");?>',
                   iconCls:'fa-user-md',
                   leaf: false,
                   expanded: false,
                   href:'/users'
                },{
                    text:'<?=__("Settings");?>',
                    iconCls: 'fa-cogs',
                    href:'/settings',
                    expanded: false,
                    children:[
                        {text:'Miro',leaf:true},
                        {text:'Pero',leaf:true}
                    ]
                },{
                    text:'<?=__("Logout");?>',
                    iconCls: 'fa-sign-out',
                    expanded: false,
                    href:'/users/logout'
                }]
            }
        }
    });
    
    // ovo loada iz viewa u centralni prozor elemente
    <?php echo $this->fetch('content'); ?>

    var menuTreeStore = Ext.create('Ext.data.TreeStore', {
        model: 'Test'
    });
  
   
    var mainPanel = new Ext.panel.Panel({
       // title: 'PetDonors.org',
       // glyph: 'xf1b0@FontAwesome',
        width: '100%',
        height: '100%',
        cls:'MainTitle',
        //height: '500px',
       // plugins: 'responsive',
        layout: 'border',
       
        items: [{
            region:'west',
            autoScroll: true,
            width: 250,
            split: true,
            layout: 'fit',
            // scrollable: 'y',
            items: [{
          title: 'PetDonors.org',
        glyph: 'xf1b0@FontAwesome',
                xtype: 'treepanel',
                store: menuTreeStore,
                rootVisible: false,
                bufferedRenderer: false,
                animate: true,
                cls:'menuTree'
                
            }]
        },{
            region:'center',
            layout:'fit',
            items:[
                <?= $loadedModule;?>
            ]
        }
        ]
        
    });
    
   
    mainPanel.render(Ext.getBody());
});
    </script>
</html>