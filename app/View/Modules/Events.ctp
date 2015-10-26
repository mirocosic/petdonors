//<script>
    
var eventsStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'Event.id',mapping:'Event.id'},
        {name:'Event.title',mapping:'Event.title'},
        
        {name:'Event.start_time',mapping:'Event.start_time'},
        {name:'Event.end_time',mapping:'Event.end_time'},
    ],
    proxy: {
        type:'ajax',
        url:'/events/getEvents'
    },
    reader: {
        type:'json'
    },
     autoLoad: true
});


 
var donorsStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'Donor.id',mapping:'Donor.id'},
        {name:'Donor.name',mapping:'Donor.name'},
        

    ],
    proxy: {
        type:'ajax',
        url:'/donors/getDonors'
    },
    reader: {
        type:'json'
    },
     autoLoad: true
});

var eventsDonorsStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'Donor.id',mapping:'id'},
        {name:'Donor.name',mapping:'name'},
        {name:'EventsDonor.donated',mapping:'EventsDonor.donated'}
    ],
    proxy:{
        type:"ajax",
        url:"/events/getEventDonors"
    },
    reader: {
        type:"json"
    }
})

var eventsTab = Ext.create('Ext.panel.Panel',{
    title:"<?=__('Donations');?>",
    glyph:'xf0fa@FontAwesome',
    items:[{
        xtype:"grid",
        store: eventsStore,
        columns:[
            {header:'ID',dataIndex:'Event.id',width:50,hidden:true},
            {header:"<?=__('Title');?>",dataIndex:'Event.title'},
           
            {
                header:"<?=__('Starts');?>",dataIndex:'Event.start_time',
                width: 100,
                xtype:'datecolumn',
                format: 'd.m.Y',                    
                convert: function (v) {return Ext.Date.parse(v, 'Y-m-d');}
            },{
                header:"<?=__('Ends');?>",dataIndex:'Event.end_time',
                width: 100,
                xtype:'datecolumn',
                format: 'd.m.Y',                    
                convert: function (v) {return Ext.Date.parse(v, 'Y-m-d');}
            },{  
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

                        var eventEditWindow = Ext.create('Ext.window.Window',{
                            title:'Event id = '+record.data.Event.id,
                            width: 300,
                            items: [{
                                xtype:"form",
                                id:"eventDataForm",
                                defaults: {
                                    xtype:'textfield',
                                    padding: "10 10 0 10",
                                    allowBlank: false
                                },
                                items:[{
                                    xtype:"hidden",
                                    name:"Event.id"
                                },{
                                    fieldLabel:"<?=__('Title');?>",
                                    name: 'Event.title'    
                                },{
                                    xtype: 'datefield',
                                    fieldLabel: "<?=__('Starts');?>",
                                    name: 'Event.start_time',
                                    format:'d.m.Y',
                                },{
                                    xtype: 'datefield',
                                    fieldLabel: "<?=__('Ends');?>",
                                    name: 'Event.end_time',
                                    format:'d.m.Y',
                                }],
                                buttons:[{
                                    formBind: true,
                                    text:"<?=__('Save');?>",
                                    handler: function(){
                                        eventEditWindow.items.get('eventDataForm').getForm().submit({
                                            url: '/events/edit',
                                            success: function (form, action) {
                                                Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                                eventsStore.load();  
                                                eventEditWindow.close();
                                            },
                                            failure: function (form, action) {
                                                Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                            }
                                        });
                                    }
                                },{
                                    text:"<?=__('Delete');?>",
                                    handler: function(){
                                        Ext.MessageBox.confirm("<?=__('Are you sure?');?>","<?=__('Delete event ');?>"+record.data.Event.name+"?",function(){
                                            Ext.Ajax.request({
                                                url: '/events/delete',
                                                params: {event_id: record.data.Event.id},
                                                success: function (response, opts) {
                                                    var obj = Ext.decode(response.responseText);
                                                    if (obj.success){
                                                        Ext.Msg.alert("<?=__('Deleted');?>",obj.message); 
                                                    } else {
                                                        Ext.Msg.alert("<?=__('Error');?>",obj.message);
                                                    }
                                                    eventEditWindow.close();
                                                    eventsStore.load();
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

                        eventEditWindow.items.get('eventDataForm').getForm().loadRecord(record);
                        eventEditWindow.show();

                    }
                }

            },{
                xtype:'widgetcolumn',
                    width:120,
                    widget:{
                        xtype: 'button',
                        text: "<?= __('Donors');?>",
                        glyph: 'xf043@FontAwesome',
                        defaultBindProperty: null, //important
                        handler: function(widgetColumn) {
                            var eventRecord = widgetColumn.getWidgetRecord();
                            var eventDonorsWindow = Ext.create('Ext.window.Window',{
                                title:"<?=__('Donors');?>",
                                glyph: 'xf043@FontAwesome',
                                width: 400,
                                height:500,
                                padding:20,
                                items:[{
                                    xtype:'container',
                                    layout:'hbox',
                                    items:[{
                                        xtype:'combobox',
                                        item_id:'addDonorCombo',
                                        hideTrigger:true,
                                        typeAhead: true,
                                        forceSeletion: true,
                                        queryMode:'local',
                                        minChars: 2,
                                        store:donorsStore,
                                        displayField:"Donor.name",
                                        valueField:'Donor.id',
                                        name:'Event.donors',
                                        fieldLabel:"<?=__('Donor');?>",
                                        listeners: {
                                            buffer: 50,
                                            beforerender:function(){
                                                var store = this.store;
                                                store.clearFilter();
                                            },
                                            change: function() {
                                              var store = this.store;
                                              store.clearFilter();
                                              //store.resumeEvents();
                                              store.filter({
                                                  property: 'Donor.name',
                                                  anyMatch: true,
                                                  value   : this.getValue()
                                              });
                                            }
                                          }

                                    },{
                                        xtype:"button",
                                        text:"<?=__('Add');?>",
                                        glyph:'xf067@FontAwesome',
                                        handler:function(){
                                            var donor_id = eventDonorsWindow.down('[item_id=addDonorCombo]').getValue();
                                            Ext.Ajax.request({
                                                url:"/events/addDonor",
                                                params:{
                                                    event_id:eventRecord.data.Event.id,
                                                    donor_id:donor_id
                                                },
                                                success:function(response){
                                                    var r = Ext.decode(response.responseText);
                                                    if(r.success == true){
                                                       // Ext.Msg.alert('Da');
                                                        eventsDonorsStore.load({params:{event_id:eventRecord.data.Event.id}});
                                                    } else {
                                                        Ext.Msg.alert("<?=__('Error');?>",r.message);
                                                    }
                                                },
                                                failure:function(response){
                                                     Ext.Msg.alert('Ne');
                                                }
                                            });
                                        }
                                    }]
                                },{
                                    padding:'20 0 0 0',
                                    xtype:'grid',
                                    store:eventsDonorsStore,
                                    columns:[
                                        {header:'Id',dataIndex:'Donor.id',width:50},
                                        {header:"<?=__('Name');?>",dataIndex:"Donor.name"},
                                        {header:"<?=__('Donated');?>",dataIndex:"EventsDonor.donated",
                                            renderer:function(val){
                                               if (val == 1) {
                                                   return "<?=__('Yes');?>"
                                               } else {
                                                   return "<?=__('No');?>"
                                               }
                                            }
                                        },
                                        {   xtype:"widgetcolumn",
                                            widget:{
                                                xtype: 'button',
                                                text: "<?= __('Remove');?>",
                                                glyph: 'xf068@FontAwesome',
                                                defaultBindProperty: null,
                                                handler:function(widgetColumn){
                                                    var donorRecord = widgetColumn.getWidgetRecord();
                                                    var events_donor_id = donorRecord.data.EventsDonor.id;
                                                    Ext.Ajax.request({
                                                        url:"/events/removeDonor",
                                                        params:{
                                                            events_donors_id:events_donor_id
                                                        },
                                                        success:function(response){
                                                            var r = Ext.decode(response.responseText);
                                                            if(r.success == true){
                                                              
                                                                eventsDonorsStore.load({params:{event_id:eventRecord.data.Event.id}});
                                                            } else {
                                                                Ext.Msg.alert("<?=__('Error');?>",r.message);
                                                            }
                                                        },
                                                        failure:function(response){
                                                             Ext.Msg.alert("<?=__('Error');?>");
                                                        }
                                                    });
                                                }
                                            }
                                    }
                                    ]
                                }]
                            });
                            eventsDonorsStore.load({params:{event_id:eventRecord.data.Event.id}});
                            eventDonorsWindow.show();
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
            var eventEditWindow = Ext.create('Ext.window.Window',{
                title:"<?=__('Create new event');?>",
                width: 300,
                items: [{
                    xtype:"form",
                    id:"eventDataForm",
                    defaults: {
                        xtype:'textfield',
                        padding: "10 10 0 10",
                        allowBlank: false
                    },
                    items:[{
                        fieldLabel:"<?=__('Title');?>",
                        name: 'Event.title'    
                    },{
                        xtype: 'datefield',
                        fieldLabel: "<?=__('Starts');?>",
                        name: 'Event.start_time',
                        format:'d.m.Y'
                    },{
                        xtype: 'datefield',
                        fieldLabel: "<?=__('Ends');?>",
                        name: 'Event.end_time',
                        format:'d.m.Y'
                    }],
                    buttons:[{
                        formBind: true,
                        text:"<?=__('Save');?>",
                        handler: function(){
                            eventEditWindow.items.get('eventDataForm').getForm().submit({
                                url: '/events/edit',
                                success: function (form, action) {
                                    Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                    eventsStore.load();  
                                    eventEditWindow.close();
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
            eventEditWindow.show();
        }
    }]
    
});