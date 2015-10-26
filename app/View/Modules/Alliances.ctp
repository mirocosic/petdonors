//<script>
    
var alliancesStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'Alliance.id',mapping:'Alliance.id'},
        {name:'Alliance.name',mapping:'Alliance.name'},
        
    ],
    proxy: {
        type:'ajax',
        url:'/alliances/index'
    },
    reader: {
        type:'json'
    },
     autoLoad: true
});
    
var alliancesTab = Ext.create('Ext.panel.Panel',{
    title:"<?=__('Alliances');?>",
    glyph:'xf19c@FontAwesome',
    items:[{
        xtype:"grid",
        store: alliancesStore,
        columns:[
            {header:'ID',dataIndex:'Alliance.id',width:50},
            {header:"<?=__('Name');?>",dataIndex:'Alliance.name'},
            {  
                xtype: 'widgetcolumn',
                stopSelection: true,
                width:120,
                widget: {
                    xtype: 'button',
                    width:50,
                    //text: "<?= __('Edit');?>",
                    glyph:'xf040@FontAwesome',
                    defaultBindProperty: null, //important
                    handler: function(widgetColumn) {
                      var record = widgetColumn.getWidgetRecord();

                        var allianceEditWindow = Ext.create('Ext.window.Window',{
                            title:'Alliance id = '+record.data.Alliance.id,
                            width: 300,
                            items: [{
                                xtype:"form",
                                id:"allianceDataForm",
                                defaults: {
                                    xtype:'textfield',
                                    padding: "10 10 0 10",
                                    allowBlank: false
                                },
                                items:[{
                                    xtype:"hidden",
                                    name:"Alliance.id"
                                },{
                                    fieldLabel:"<?=__('Name');?>",
                                    name: 'Alliance.name'    
                                }],
                                buttons:[{
                                    formBind: true,
                                    text:"<?=__('Save');?>",
                                    handler: function(){
                                        allianceEditWindow.items.get('allianceDataForm').getForm().submit({
                                            url: '/alliances/edit',
                                            success: function (form, action) {
                                                Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                                alliancesStore.load();  
                                                allianceEditWindow.close();
                                            },
                                            failure: function (form, action) {
                                                Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                            }
                                        });
                                    }
                                },{
                                    text:"<?=__('Delete');?>",
                                    handler: function(){
                                        Ext.MessageBox.confirm("<?=__('Are you sure?');?>","<?=__('Delete alliance ');?>"+record.data.Alliance.name+"?",function(){
                                            Ext.Ajax.request({
                                                url: '/alliances/delete',
                                                params: {alliance_id: record.data.Alliance.id},
                                                success: function (response, opts) {
                                                    var obj = Ext.decode(response.responseText);
                                                    if (obj.success){
                                                        Ext.Msg.alert("<?=__('Deleted');?>",obj.message); 
                                                    } else {
                                                        Ext.Msg.alert("<?=__('Error');?>",obj.message);
                                                    }
                                                    allianceEditWindow.close();
                                                    alliancesStore.load();
                                                },
                                                failure: function (response, opts) {
                                                    Ext.Msg.alert("<?=__('Error');?>",response.message);
                                                }
                                            });
                                        })
                                    }
                                }]

                            }]
                         });

                        allianceEditWindow.items.get('allianceDataForm').getForm().loadRecord(record);
                        allianceEditWindow.show();

                    }
                }

            }
        ]
    },{
        xtype:'button',
        margin: '20 0 0 20',
        text:"<?=__('Create');?>",
        glyph:'xf067@FontAwesome',
        handler:function(){
            var allianceEditWindow = Ext.create('Ext.window.Window',{
                title:"<?=__('Create new alliance');?>",
                width: 300,
                items: [{
                    xtype:"form",
                    id:"allianceDataForm",
                    defaults: {
                        xtype:'textfield',
                        padding: "10 10 0 10",
                        allowBlank: false
                    },
                    items:[{
                        fieldLabel:"<?=__('Title');?>",
                        name: 'Alliance.title'    
                    }],
                    buttons:[{
                        formBind: true,
                        text:"<?=__('Save');?>",
                        handler: function(){
                            allianceEditWindow.items.get('allianceDataForm').getForm().submit({
                                url: '/alliances/edit',
                                success: function (form, action) {
                                    Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                    alliancesStore.load();  
                                    allianceEditWindow.close();
                                },
                                failure: function (form, action) {
                                    Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                }
                            });
                        }
                    },{
                        text:"<?=__('Delete');?>"
                    }]

                }]
             });
            allianceEditWindow.show();
        }
    }]
    
});