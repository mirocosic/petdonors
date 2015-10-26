//<script>
    
var competitionsStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'Competition.id',mapping:'Competition.id'},
        {name:'Competition.title',mapping:'Competition.title'},
        {name:'Competition.type_id',mapping:'Competition.type_id'},
        {name:'Competition.start_date',mapping:'Competition.start_date'},
        {name:'Competition.end_date',mapping:'Competition.end_date'},
    ],
    proxy: {
        type:'ajax',
        url:'/competitions/index'
    },
    reader: {
        type:'json'
    },
     autoLoad: true
});

 
var competitionTypesStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'CompetitionType.id',mapping:'CompetitionType.id'},
        {name:'CompetitionType.name',mapping:'CompetitionType.name'},
    ],
    proxy: {
        type:'ajax',
        url:'/competitions/getCompetitionTypes'
    },
    reader: {
        type:'json'
    },
     autoLoad: true
});

var competitionEventsStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'Event.id',mapping:'id'},
        {name:'Event.title',mapping:'title'},
    ],
    proxy:{
        type:'ajax',
        url:'/competitions/getCompetitionEvents'
    },
    reader:{
        type:'json'
    }
});
    
var competitionsTab = Ext.create('Ext.panel.Panel',{
    title:"<?=__('Competitions');?>",
    glyph:'xf091@FontAwesome',
    items:[{
        xtype:"grid",
        store: competitionsStore,
        columns:[
            {header:'ID',dataIndex:'Competition.id',width:50},
            {header:"<?=__('Title');?>",dataIndex:'Competition.title'},
            {header:"<?=__('Type');?>",dataIndex:'Competition.type_id'},
            {
                header:"<?=__('Starts');?>",dataIndex:'Competition.start_date',
                width: 100,
                xtype:'datecolumn',
                format: 'd.m.Y',                    
                convert: function (v) {return Ext.Date.parse(v, 'Y-m-d');}
            },{
                header:"<?=__('Ends');?>",dataIndex:'Competition.end_date',
                width: 100,
                xtype:'datecolumn',
                format: 'd.m.Y',                    
                convert: function (v) {return Ext.Date.parse(v, 'Y-m-d');}
            },{     
                xtype: 'widgetcolumn',
                stopSelection: true,
               // width:120,
                widget: {
                    xtype: 'button',
                    width:50,
                    //text: "<?= __('Edit');?>",
                    glyph:'xf040@FontAwesome',
                    defaultBindProperty: null, //important
                    handler: function(widgetColumn) {
                      var record = widgetColumn.getWidgetRecord();

                        var competitionEditWindow = Ext.create('Ext.window.Window',{
                            title:'Competition id = '+record.data.Competition.id,
                            width: 300,
                            items: [{
                                xtype:"form",
                                id:"competitionDataForm",
                                defaults: {
                                    xtype:'textfield',
                                    padding: "10 10 0 10",
                                    allowBlank: false
                                },
                                items:[{
                                    xtype:"hidden",
                                    name:"Competition.id"
                                },{
                                    fieldLabel:"<?=__('Title');?>",
                                    name: 'Competition.title'    
                                },{
                                    xtype:'combobox',
                                    name:'Competition.type',
                                    minChars: 2,
                                    store:competitionTypesStore,
                                    displayField:"CompetitionType.name",
                                    valueField:'CompetitionType.id',
                                    fieldLabel:"<?=__('Competition type');?>",
                                },{
                                    xtype: 'datefield',
                                    fieldLabel: "<?=__('Starts');?>",
                                    name: 'Competition.start_date',
                                    format:'d.m.Y',
                                },{
                                    xtype: 'datefield',
                                    fieldLabel: "<?=__('Ends');?>",
                                    name: 'Competition.end_date',
                                    format:'d.m.Y',
                                }],
                                buttons:[{
                                    formBind: true,
                                    text:"<?=__('Save');?>",
                                    handler: function(){
                                        competitionEditWindow.items.get('competitionDataForm').getForm().submit({
                                            url: '/competitions/edit',
                                            success: function (form, action) {
                                                Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                                competitionsStore.load();  
                                                competitionEditWindow.close();
                                            },
                                            failure: function (form, action) {
                                                Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                            }
                                        });
                                    }
                                },{
                                    text:"<?=__('Delete');?>",
                                    handler: function(){
                                        Ext.MessageBox.confirm("<?=__('Are you sure?');?>","<?=__('Delete competition ');?>"+record.data.Competition.name+"?",function(){
                                            Ext.Ajax.request({
                                                url: '/competitions/delete',
                                                params: {competition_id: record.data.Competition.id},
                                                success: function (response, opts) {
                                                    var obj = Ext.decode(response.responseText);
                                                    if (obj.success){
                                                        Ext.Msg.alert("<?=__('Deleted');?>",obj.message); 
                                                    } else {
                                                        Ext.Msg.alert("<?=__('Error');?>",obj.message);
                                                    }
                                                    competitionEditWindow.close();
                                                    competitionsStore.load();
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

                        competitionEditWindow.items.get('competitionDataForm').getForm().loadRecord(record);
                        competitionEditWindow.show();

                    }
                }
            },{
                xtype: 'widgetcolumn',
                stopSelection: true,
                width:120,
                widget:{
                    xtype: 'button',
                    width:100,
                    text: "<?= __('Events');?>",
                    glyph:'xf073@FontAwesome',
                    defaultBindProperty: null, //important
                    handler:function(widgetColumn){
                        var record = widgetColumn.getWidgetRecord();
                        var eventsWindow = Ext.create('Ext.window.Window',{
                            title:"<?=__('Events');?>",
                            width:300,
                            items:[{
                                xtype:'grid',
                                store:competitionEventsStore,
                                padding:'20 0 0 0',
                                columns:[
                                    {header:'Id',dataIndex:'Event.id'},
                                    {header:"<?=__('Title');?>",dataIndex:'Event.title'},
                                ],
                            }]
                        });
                        competitionEventsStore.load({params:{competition_id:record.data.Competition.id}});
                        eventsWindow.show();
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
            var competitionEditWindow = Ext.create('Ext.window.Window',{
                title:"<?=__('Create new competition');?>",
                width: 300,
                items: [{
                    xtype:"form",
                    id:"competitionDataForm",
                    defaults: {
                        xtype:'textfield',
                        padding: "10 10 0 10",
                        allowBlank: false
                    },
                    items:[{
                        fieldLabel:"<?=__('Title');?>",
                        name: 'Competition.title'    
                    },{
                        xtype:'combobox',
                        name:'Competition.type',
                        minChars: 2,
                        store:competitionTypesStore,
                        displayField:"CompetitionType.name",
                        valueField:'CompetitionType.id',
                        fieldLabel:"<?=__('Competition type');?>"
                    },{
                        xtype: 'datefield',
                        fieldLabel: "<?=__('Starts');?>",
                        name: 'Competition.start_date',
                        format:'d.m.Y'
                    },{
                        xtype: 'datefield',
                        fieldLabel: "<?=__('Ends');?>",
                        name: 'Competition.end_date',
                        format:'d.m.Y'
                    }],
                    buttons:[{
                        formBind: true,
                        text:"<?=__('Save');?>",
                        handler: function(){
                            competitionEditWindow.items.get('competitionDataForm').getForm().submit({
                                url: '/competitions/edit',
                                success: function (form, action) {
                                    Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                    competitionsStore.load();  
                                    competitionEditWindow.close();
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

           // clubEditWindow.items.get('clubDataForm').getForm().loadRecord(record);
            competitionEditWindow.show();
        }
    }]
    
});