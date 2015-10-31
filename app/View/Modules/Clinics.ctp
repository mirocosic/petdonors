//<script>
var clinicsStore = Ext.create('Ext.data.Store',{
    fields: [
        {name:'Clinic.id',mapping:'Clinic.id'},
        {name:'Clinic.name',mapping:'Clinic.name'},
        {name:'Clinic.address',mapping:'Clinic.address'},
        {name:'Clinic.city',mapping:'Clinic.city'},
        {name:'Clinic.latitude',mapping:'Clinic.latitude'},
        {name:'Clinic.longitude',mapping:'Clinic.longitude'}
    ],
    proxy: {
        type:'ajax',
        url:'/clinics/getClinics'
    },
    reader: {
        type:'json'
    },
    autoLoad: true
});

 
var membersStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'User.id',mapping:'User.id'},
        {name:'User.name',mapping:'User.name'},
        {name:'User.surname',mapping:'User.surname'},
        {name:'User.mail',mapping:'User.mail'},
        {name:'User.username',mapping:'User.username'}

    ],
    proxy: {
        type:'ajax',
        url:'/users/index'
    },
    reader: {
        type:'json'
    },
     autoLoad: true
});
    
   
    
var clinicMembersStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'User.id',mapping:'id'},
        {name:'User.username',mapping:'username'},
        {name:'UsersClinic.admin',mapping:'UsersClinic.admin'}
    ],
    proxy:{
        type:"ajax",
        url:"/clinics/getMembers"
    },
    reader: {
        type:"json"
    }
});

 var clinicsGrid = new Ext.grid.GridPanel({
        title:"<?=__('Clinics');?>",
        glyph:"xf0f8@FontAwesome",
        
            store:clinicsStore,
            columns:[
                {header:'ID',dataIndex:'Clinic.id',width:50},
                {header:"<?=__('Name');?>",dataIndex:'Clinic.name'},
                {header:"<?=__('Address');?>",dataIndex:'Clinic.address'},
                {header:"<?=__('City');?>",dataIndex:'Clinic.city'},
                {   stopSelection: true,
                    xtype: 'widgetcolumn',
                    width:120,
                    widget: {
                        xtype: 'button',
                        text: "<?= __('Edit');?>",
                        glyph:'xf040@FontAwesome',
                        defaultBindProperty: null, //important
                        handler: function(widgetColumn) {
                          var record = widgetColumn.getWidgetRecord();
                            
                            var clinicEditWindow = Ext.create('Ext.window.Window',{
                                title:'Clinic id = '+record.data.Clinic.id,
                                width: 300,
                                items: [{
                                    xtype:"form",
                                    id:"clinicDataForm",
                                    defaults: {
                                        xtype:'textfield',
                                        padding: "10 10 0 10",
                                        allowBlank: false
                                    },
                                    items:[{
                                        xtype:"hidden",
                                        name:"Clinic.id"
                                    },{
                                        fieldLabel:"<?=__('Name');?>",
                                        name: 'Clinic.name'    
                                    },{
                                        fieldLabel:"<?=__('Address');?>",
                                        name: 'Clinic.address'    
                                    },{
                                        fieldLabel:"<?=__('City');?>",
                                        name: 'Clinic.city'    
                                    },{
                                        name: 'Clinic.latitude',
                                        hidden: true,
                                        value:'0'
                                    },{
                                        name: 'Clinic.longitude',
                                        hidden: true,
                                        value:'0'
                                    },],
                                    buttons:[{
                                        formBind: true,
                                        text:"<?=__('Save');?>",
                                        handler: function(){
                                           
                                            var geocoder = new google.maps.Geocoder();
                                            var clinicForm = clinicEditWindow.items.get('clinicDataForm');
                                            var address = clinicForm.down('[name=Clinic.address]').getValue();
                                            geocoder.geocode({'address': address}, function(results, status) {
                                                if (status === google.maps.GeocoderStatus.OK) {

                                                    clinicForm.down('[name=Clinic.latitude]').setValue(results[0].geometry.location.lat());
                                                    clinicForm.down('[name=Clinic.longitude]').setValue(results[0].geometry.location.lng());
                                                } else {
                                                   // do something smart
                                                }
                                                clinicEditWindow.items.get('clinicDataForm').getForm().submit({
                                                    url: '/clinics/edit',
                                                    success: function (form, action) {
                                                        Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                                        clinicsStore.load();  
                                                        clinicEditWindow.close();
                                                    },
                                                    failure: function (form, action) {
                                                        Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                                    }
                                                });
                                            });
                                        }
                                    },{
                                        text:"<?=__('Delete');?>",
                                        handler: function(){
                                            Ext.MessageBox.confirm("<?=__('Are you sure?');?>","<?=__('Delete clinic ');?>"+record.data.Clinic.name+"?",function(){
                                                Ext.Ajax.request({
                                                    url: '/clinics/delete',
                                                    params: {id: record.data.Clinic.id},
                                                    success: function (response, opts) {
                                                        var obj = Ext.decode(response.responseText);
                                                        if (obj.success){
                                                            Ext.Msg.alert("<?=__('Deleted');?>",obj.message); 
                                                        } else {
                                                            Ext.Msg.alert("<?=__('Error');?>",obj.message);
                                                        }
                                                        clinicEditWindow.close();
                                                        clinicsStore.load();
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
                             
                            clinicEditWindow.items.get('clinicDataForm').getForm().loadRecord(record);
                            clinicEditWindow.show();
                            
                        }
                    }
                   
                },{
                    xtype:'widgetcolumn',
                    width:120,
                    widget:{
                        xtype: 'button',
                        text: "<?= __('Vets');?>",
                        glyph: 'xf0f0@FontAwesome',
                        defaultBindProperty: null, //important
                        handler: function(widgetColumn) {
                            var clinicRecord = widgetColumn.getWidgetRecord();
                            var clinicMembersWindow = Ext.create('Ext.window.Window',{
                                title:"<?=__('Members');?>",
                                glyph: 'xf0c0@FontAwesome',
                                width: 400,
                                height:500,
                                padding:20,
                                items:[{
                                    xtype:'container',
                                    layout:'hbox',
                                    items:[{
                                        xtype:'combobox',
                                        item_id:'addMemberCombo',
                                        hideTrigger:true,
                                        typeAhead: true,
                                        forceSeletion: true,
                                        queryMode:'local',
                                        minChars: 2,
                                        store:membersStore,
                                        displayField:"User.username",
                                        valueField:'User.id',
                                        name:'Clinic.members',
                                        fieldLabel:"<?=__('User');?>",
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
                                                  property: 'User.username',
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
                                            var user_id = clinicMembersWindow.down('[item_id=addMemberCombo]').getValue();
                                            Ext.Ajax.request({
                                                url:"/clinics/addMember",
                                                params:{
                                                    clinic_id:clinicRecord.data.Clinic.id,
                                                    user_id:user_id
                                                },
                                                success:function(response){
                                                    var r = Ext.decode(response.responseText);
                                                    if(r.success == true){
                                                       // Ext.Msg.alert('Da');
                                                        clinicMembersStore.load({params:{clinic_id:clinicRecord.data.Clinic.id}});
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
                                    store:clinicMembersStore,
                                    columns:[
                                        {header:'Id',dataIndex:'User.id',width:50},
                                        {header:"<?=__('Username');?>",dataIndex:"User.username"},
                                        {header:"Admin",dataIndex:"UsersClinic.admin",
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
                                                    var memberRecord = widgetColumn.getWidgetRecord();
                                                    var users_clinic_id = memberRecord.data.UsersClinic.id;
                                                    Ext.Ajax.request({
                                                        url:"/clinics/removeMember",
                                                        params:{
                                                            users_clinic_id:users_clinic_id
                                                        },
                                                        success:function(response){
                                                            var r = Ext.decode(response.responseText);
                                                            if(r.success == true){
                                                              
                                                                clinicMembersStore.load({params:{clinic_id:clinicRecord.data.Clinic.id}});
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
                            clinicMembersStore.load({params:{clinic_id:clinicRecord.data.Clinic.id}});
                            clinicMembersWindow.show();
                        }
                    }
                }
                
            ],
            tbar:[{
                xtype:'button',
                text:'<?=__("New clinic");?>',
                glyph:'xf067@FontAwesome',
                handler:function(){
                    var clinicEditWindow = Ext.create('Ext.window.Window',{
                        title:"<?=__('Create new clinic');?>",
                        width: 300,
                        autoShow: true,
                        items: [{
                            xtype:"form",
                            id:"clinicDataForm",
                            defaults: {
                                xtype:'textfield',
                                padding: "10 10 0 10",
                                allowBlank: false
                            },
                            items:[{
                                fieldLabel:"<?=__('Name');?>",
                                name: 'Clinic.name'    
                            },{
                                fieldLabel:"<?=__('Address');?>",
                                name: 'Clinic.address'    
                            },{
                                
                                name: 'Clinic.latitude',
                                hidden: true,
                                value:'0'
                            },{
                               
                                name: 'Clinic.longitude'   ,
                                hidden: true,
                                value:'0'
                            }],
                            buttons:[{
                                formBind: true,
                                text:"<?=__('Save');?>",
                                handler: function(){
                                    
                                    // add geocodeing function
                                    var geocoder = new google.maps.Geocoder();
                                    var clinicForm = clinicEditWindow.items.get('clinicDataForm');
                                    var address = clinicForm.down('[name=Clinic.address]').getValue();
                                    geocoder.geocode({'address': address}, function(results, status) {
                                        if (status === google.maps.GeocoderStatus.OK) {
                                            
                                            clinicForm.down('[name=Clinic.latitude]').setValue(results[0].geometry.location.lat());
                                            clinicForm.down('[name=Clinic.longitude]').setValue(results[0].geometry.location.lng());
                                        } else {
                                                
                                        }
                                        clinicEditWindow.items.get('clinicDataForm').getForm().submit({
                                            url: '/clinics/edit',
                                            success: function (form, action) {
                                                Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                                clinicsStore.load();  
                                                clinicEditWindow.close();
                                            },
                                            failure: function (form, action) {
                                                Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                            }
                                        });
                                        
                                    });
                                    
                                }
                            },{
                                text:"<?=__('Delete');?>"
                            }]

                        }]
                     });

                }
            },{
                // show clinic map
                xtype:'button',
                glyph:'xf041@FontAwesome',
                handler:function(){
                    var mapwin = Ext.create('Ext.window.Window', {
                            autoShow: true,
                            layout: 'fit',
                            title: '<?=__("Clinics map");?>',
                            glyph:'xf041@FontAwesome',
                            closeAction: 'destroy',
                            width:750,
                            height:550,
                            border: true,
                            items: {
                                xtype: 'gmappanel',
                                id : 'clinicsMap',
                                center: {
                                    geoCodeAddr: 'Stjepana Ljubića Vojvode 18, Zagreb',
                                    marker: {title: 'Home'}
                                },
                                mapOptions : {
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                },
                                 listeners : {
                                    idle:function(){
                                       
                                         
                                    }
                                },
                            }
                        });
                        
                    var clinics = [];
                    clinicsStore.each(function(record){
                        clinics.push(record['data']['Clinic']);
                    });    
                    //ovo je ruzno i treba popraviti, okinuti na neki load event od gmaps
                    Ext.defer(function(){drawClinicMarkers(clinics);},500);
                                        
                   
                }
            }],
            dockedItems: [{
                xtype: 'pagingtoolbar',
                dock: 'bottom',
                //plugins: {ptype: 'pagesize', displayText: 'Donora po stranici'},
                //pageSize: 10,
                beforePageText: 'Stranica',
                afterPageText: 'od {0}',
                store: clinicsStore,
                displayInfo: true,
                displayMsg: '<?=__('Donori {0} - {1} of {2}')?>',
                emptyMsg: "<?=__('Nema donora')?>"
            }]
    });
    
function drawClinicMarkers(clinics) {
    var clinicsMap = Ext.getCmp('clinicsMap');
   
    Ext.each(clinics, function(clinic, index){
        if(clinic.latitude == 0){
            return;
        };
        var infowindow = new google.maps.InfoWindow({
            content: 
                '<div style="font-size: 0.9em;">'+
                    '<b><?=__('Name');?></b>: '+clinic.name+'<br/>'+
                    '<b><?=__('Address');?></b>: '+clinic.address+'<br/>'+
                '</div>'
        });
        var latlng = new google.maps.LatLng(clinic.latitude,clinic.longitude);
        
        var marker = new google.maps.Marker({
            title: 'Hello World!',
            position: latlng,
            //position:{lat:45.77433690, lng:15.95949510},
            map:clinicsMap.gmap
        });
       
        marker.addListener('click', function() {
            infowindow.open(clinicsMap.gmap, marker);
        });
    });
}

 

    