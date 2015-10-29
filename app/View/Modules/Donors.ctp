//<script> 
var donorsStore = Ext.create('Ext.data.Store',{
    fields:[
        {name:'Donor.id',mapping:'Donor.id'},
        {name:'Donor.name',mapping:'Donor.name'},
        {name:'Donor.address',mapping:'Donor.address'},
        {name:'Donor.contact_name',mapping:'Donor.contact_name'},
        {name:'Donor.contact_number',mapping:'Donor.contact_number'},
        {name:'Donor.contact_mail',mapping:'Donor.contact_mail'},
        {name:'Donor.contact_oib',mapping:'Donor.contact_oib'},
        {name:'Donor.date_of_birth',mapping:'Donor.date_of_birth'},
        {name:'Donor.gender',mapping:'Donor.gender'},
        {name:'Donor.weight',mapping:'Donor.weight'},
        {name:'Donor.vaccinated',mapping:'Donor.vaccinated'},
        {name:'Donor.microchipped',mapping:'Donor.microchipped'}

    ],
    proxy: {
        type:'ajax',
        url:'/donors/getDonors',
        simpleSortMode: 'true',
    },
    reader: {
        type:'json',
        totalProperty: 'total'
    },
    pageSize: 100,
    autoLoad: true,
    //sortOnLoad: true,
    //sorters: { property: 'Donor.name', direction : 'DESC' }
});

var donorsGridFilters = {
    ftype:'filters',
    encode: true,
    local: false,
    filters:[{
        type:'string',
        dataIndex:'name'
    }]
};

var genderStore = Ext.create('Ext.data.Store', {
    fields: ['abbr', 'name'],
    data : [
        {"abbr":"M", "name":"<?=__('Male');?>"},
        {"abbr":"F", "name":"<?=__('Female');?>"}
       
    ]
});

var trueStore = Ext.create('Ext.data.Store', {
    fields: ['abbr', 'name'],
    data : [
        {"abbr":"0", "name":"<?=__('No');?>"},
        {"abbr":"1", "name":"<?=__('Yes');?>"}
       
    ]
});

var donorsGrid = new Ext.grid.GridPanel({
        title: '<?= __("Donors");?>',
        glyph: 'xf043@FontAwesome',
        plugins: 'gridfilters',
        store:donorsStore,
           
            columns: [
                {header:'Id',dataIndex:'Donor.id',width:50},
                {header:'<?=__("Name");?>',dataIndex:'Donor.name',filter: {type: 'string'}},
                {header:'<?=__("Address");?>',dataIndex:'Donor.address',filter:{type:'string'}},
                {header:'<?=__("Contact name");?>',dataIndex:'Donor.contact_name',hidden:true},
                {header:'<?=__("Contact number");?>',dataIndex:'Donor.contact_number',hidden:true},
                {header:'<?=__("Contact mail");?>',dataIndex:'Donor.contact_mail',hidden:true},
                {header:'<?=__("Contact oib");?>',dataIndex:'Donor.contact_oib',hidden:true},
                {header:'<?=__("Gender");?>',dataIndex:'Donor.gender',
                    filter:{
                        type:'list',
                        options:[{'id':'M','text':'<?=__("Male");?>'},{'id':'F','text':'<?=__("Female");?>'}]
                }},
                {header:'<?=__("Weight");?>',dataIndex:'Donor.weight',
                    filter:{type:'number'},
                    renderer:function(val){
                        return val+' kg';
                    }
                },
                {header:'<?=__("Vaccinated");?>',dataIndex:'Donor.vaccinated',
                    filter:{
                        type:'boolean',
                        yesText:'Da',
                        noText:'Ne'
                    },
                    renderer: function(val){
                        if (val == '0'){ return '<?=__('No');?>';} 
                        else { return '<?=__('Yes');?>';}
                    }
                },
                {header:'<?=__("Microchipped");?>',dataIndex:'Donor.microchipped',
                    filter:{
                        type:'boolean',
                        yesText:'Da',
                        noText:'Ne'
                    },
                    renderer: function(val){
                        if (val == '0'){ return '<?=__('No');?>';} 
                        else { return '<?=__('Yes');?>';}
                    }
                },
                {header:'<?=__("Age");?>',dataIndex:'Donor.date_of_birth',
                    width: 100,
                    filter:{type:'number'},
                    renderer: function(dateString){
                        var today = new Date();
                        var birthDate = new Date(dateString);
                        var age = today.getFullYear() - birthDate.getFullYear();
                        var m = today.getMonth() - birthDate.getMonth();
                        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                        }
                        return age;
                    }
                   
                },
                {header:'<?=__("Date of birth");?>',dataIndex:'Donor.date_of_birth',
                    width: 100,
                    xtype:'datecolumn',
                    format: 'd.m.Y',      
                    hidden: true,
                    convert: function (v) {return Ext.Date.parse(v, 'Y-m-d');}
                },
                {align: 'center',
                    stopSelection: true,
                    xtype: 'widgetcolumn',
                    width:50,
                    widget: {
                        xtype: 'button',
                        height:30,
                        glyph:'xf040@FontAwesome',
                     //   _btnText: "<?= __('Edit');?>",
                        defaultBindProperty: null, //important
                        handler: function(widgetColumn) {
                            var record = widgetColumn.getWidgetRecord();
                            var donorEditWindow = Ext.create('Ext.window.Window',{
                                title:'Donor id = '+record.data.Donor.id,
                                width: 300,
                                //height: 300,
                                items: [{
                                    xtype:"form",
                                    id:"donorDataForm",
                                    defaults: {
                                        xtype:'textfield',
                                        padding: "10 10 0 10",
                                        allowBlank: false,
                                        blankText:"Warning!"
                                    },
                                    items:[{
                                            xtype:"hidden",
                                            name:"Donor.id"
                                    },{
                                        fieldLabel:"<?=__('Name');?>",
                                        name: 'Donor.name'    
                                    },{
                                        name:"Donor.address",
                                        fieldLabel:"<?=__('Address');?>"
                                    },{
                                        name:"Donor.contact_name",
                                        fieldLabel:"<?=__('Contact name');?>"
                                    },{
                                        name:"Donor.contact_number",
                                        fieldLabel:"<?=__('Contact number');?>"
                                    },{
                                        name:'Donor.contact_mail',
                                        fieldLabel:"<?=__('Contact mail');?>",
                                        allowBlank: true
                                    },{
                                        name:'Donor.contact_oib',
                                        fieldLabel:"<?=__('Contact oib');?>",
                                        allowBlank: true
                                    },{
                                        xtype:'combobox',
                                        name:"Donor.gender",
                                        fieldLabel:"<?=__('Gender');?>",
                                        allowBlank: true,
                                        displayField:'name',
                                        valueField:'abbr',
                                        store: genderStore
                                    },{
                                        xtype:'combobox',
                                        name:"Donor.vaccinated",
                                        fieldLabel:"<?=__('Vaccinated');?>",
                                        allowBlank: true,
                                        displayField:'name',
                                        valueField:'abbr',
                                        store: trueStore
                                    },{
                                        xtype:'combobox',
                                        name:"Donor.microchipped",
                                        fieldLabel:"<?=__('Microchipped');?>",
                                        allowBlank: true,
                                        displayField:'name',
                                        valueField:'abbr',
                                        store: trueStore
                                    },{
                                        name:"Donor.date_of_birth",
                                        fieldLabel:"<?=__('Date of birth');?>",
                                        xtype: 'datefield',
                                        format:'d.m.Y',
                                    },{
                                        name:'Donor.weight',
                                        fieldLabel:"<?=__('Weight (kg)');?>"
                                    }],
                                    buttons:[{
                                        formBind: true,
                                        text:"<?=__('Save');?>",
                                        handler: function(){
                                            donorEditWindow.items.get('donorDataForm').getForm().submit({
                                                url: '/donors/edit',
                                                success: function (form, action) {
                                                    Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                                    donorsStore.load();  
                                                    donorEditWindow.close();
                                                },
                                                failure: function (form, action) {
                                                    Ext.Msg.alert("<?=__('Error');?>", action.result.message);
                                                }
                                            });
                                        }
                                    },{
                                        text:"<?=__('Delete');?>",
                                          handler: function(){
                                            Ext.MessageBox.confirm("<?=__('Are you sure?');?>","<?=__('Delete donor ');?>"+record.data.Donor.name+"?",function(){
                                                Ext.Ajax.request({
                                                    url: '/donors/delete',
                                                    params: {donor_id: record.data.Donor.id},
                                                    success: function (response, opts) {
                                                        var obj = Ext.decode(response.responseText);
                                                        if (obj.success == true){
                                                            Ext.Msg.alert("<?=__('Deleted');?>",obj.message); 
                                                        } else {
                                                            Ext.Msg.alert("<?=__('Error');?>",obj.message);
                                                        }
                                                        donorEditWindow.close();
                                                        donorsStore.load();
                                                    },
                                                    failure: function (response, opts) {
                                                        Ext.Msg.alert("<?=__('Error');?>",response.message);
                                                    }
                                                });
                                            })
                                        }
                                    }]
                                        
                                }]
                             })
                            donorEditWindow.items.get('donorDataForm').getForm().loadRecord(record);
                            donorEditWindow.show();
                        },
                        listeners: {
                              beforerender: function(widgetColumn){
                                  var record = widgetColumn.getWidgetRecord();
                                  widgetColumn.setText( widgetColumn._btnText ); //can be mixed with the row data if needed
                              }
                          }
                    }
                },
                {align: 'center',
                    stopSelection: true,
                    xtype: 'widgetcolumn',
                    width:50,
                    widget: {
                        xtype: 'button',
                        height:30,
                        glyph:'xf06e@FontAwesome',
                        defaultBindProperty: null, //important
                        handler: function(widgetColumn){
                             var record = widgetColumn.getWidgetRecord();
                            // window.location.href = '/donors/view/'+record.data.Donor.id;
                            var donorViewWindow = Ext.create('Ext.window.Window',{
                                title:'Donor id = '+record.data.Donor.id,
                                width: 400,
                                //height: 300,
                                items: [{
                                    xtype:"form",
                                    id:"donorViewForm",
                                    defaults: {
                                        xtype:'displayfield',
                                        padding: "10 10 0 10",
                                        allowBlank: false,
                                        blankText:"Warning!"
                                    },
                                    items:[{
                                            xtype:"hidden",
                                            name:"Donor.id"
                                    },{
                                        fieldLabel:"<?=__('Name');?>",
                                        name: 'Donor.name'    
                                    },{
                                        fieldLabel:"<?=__('Age');?>",
                                        name: 'Donor.date_of_birth',
                                        renderer: function(dateString){
                                            var today = new Date();
                                            var birthDate = new Date(dateString);
                                            var age = today.getFullYear() - birthDate.getFullYear();
                                            var m = today.getMonth() - birthDate.getMonth();
                                            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                                                age--;
                                            }
                                            return age;
                                        }
                                    },{
                                        name:"Donor.address",
                                        fieldLabel:"<?=__('Address');?>"
                                    },{
                                        name:"Donor.contact_name",
                                        fieldLabel:"<?=__('Contact name');?>"
                                    },{
                                        name:"Donor.contact_number",
                                        fieldLabel:"<?=__('Contact number');?>"
                                    },{
                                        name:'Donor.contact_mail',
                                        fieldLabel:"<?=__('Contact mail');?>",
                                        allowBlank: true
                                    },{
                                        name:'Donor.contact_oib',
                                        fieldLabel:"<?=__('Contact oib');?>",
                                        allowBlank: true
                                    },{
                                        //xtype:'combobox',
                                        name:"Donor.gender",
                                        fieldLabel:"<?=__('Gender');?>",
                                        //allowBlank: true,
                                        displayField:'name',
                                        valueField:'abbr',
                                        store: genderStore
                                    },{
                                        name:'Donor.weight',
                                        fieldLabel:"<?=__('Weight (kg)');?>"
                                    }],
                                   
                                        
                                }]
                             })
                            donorViewWindow.items.get('donorViewForm').getForm().loadRecord(record);
                            donorViewWindow.show();
                        },
                        listeners: {
                              beforerender: function(widgetColumn){
                                  var record = widgetColumn.getWidgetRecord();
                                  widgetColumn.setText( widgetColumn._btnText ); //can be mixed with the row data if needed
                              }
                          }
                    }
                }
                            
            ],
            tbar:[{
                xtype:'button',
                text:'<?=__("Create donor");?>',
                glyph:'xf067@FontAwesome',
            },{
                xtype:'button',
                text:'<?=__("Create action");?>',
                glyph:'xf067@FontAwesome',
                handler:function(){
                    //Ext.Msg.confirm('<?=__('Are you sure?');?>','<?=__("Create new action with these donors?");?>',createAction)
                    Ext.MessageBox.prompt('<?=__('Create new action');?>','<?=__("Title");?>',createAction);
                }
            },{
                xtype:'button',
                glyph:'xf041@FontAwesome',
                handler:function(){
                    
                    var mapwin = Ext.create('Ext.window.Window', {
                            autoShow: true,
                            layout: 'fit',
                            title: '<?=__("Donors map");?>',
                            glyph:'xf041@FontAwesome',
                            closeAction: 'destroy',
                            width:750,
                            height:550,
                            border: true,
                           
                            items: {
                                xtype: 'gmappanel',
                                id : 'donorsMap',
                                center: {
                                    geoCodeAddr: 'Stjepana Ljubića Vojvode 18, Zagreb',
                                    marker: {title: 'Home'}
                                },
                               
                                mapOptions : {
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                }
                                
                            },
                           
                        });
                    var data = donorsStore.getRange();
                    var donors = [];
                    donorsStore.each(function(record){
                       // console.log(record['data']['Donor']['id']);
                        donors.push(record['data']['Donor']);
                    });    
                   // var donors = new Array('Anićeva 14, Zagreb');
                    drawMarkers(donors); 
                    
                }
            }
                
            ],
            dockedItems: [{
                xtype: 'pagingtoolbar',
                dock: 'bottom',
                //plugins: {ptype: 'pagesize', displayText: 'Donora po stranici'},
                //pageSize: 10,
                beforePageText: 'Stranica',
                afterPageText: 'od {0}',
                store: donorsStore,
                displayInfo: true,
                displayMsg: '<?php echo __('Donori {0} - {1} of {2}')?>',
                emptyMsg: "<?php echo __('Nema donora')?>"
            }]
            
        });

function drawMarkers(donors) {
    var geocoder = new google.maps.Geocoder();
    var donorsMap = Ext.getCmp('donorsMap');
    //console.log(donorsMap);
    
    Ext.each(donors, function(donor, index){
     //console.log(donor.address);
       
        geocoder.geocode({'address': donor.address}, function(results, status) {
          if (status === google.maps.GeocoderStatus.OK) {
            //console.log(results[0].geometry.location);
            
            var infowindow = new google.maps.InfoWindow({
                content: 
                    '<div style="font-size: 0.9em;">'+
                        '<b><?=__('Name');?></b>: '+donor.name+'<br/>'+
                        '<b><?=__('Address');?></b>: '+donor.address+'<br/>'+
                        '<b><?=__('Contact name');?></b>: '+donor.contact_name+'<br/>'+
                        '<b><?=__('Contact number');?></b>: '+donor.contact_number+'<br/>'+
                    '</div>'
                     
              });
              
            var marker = new google.maps.Marker({
                title: 'Hello World!',
                position: results[0].geometry.location,
                map:donorsMap.gmap
            });
           
            marker.addListener('click', function() {
                infowindow.open(donorsMap.gmap, marker);
            });
          
          //  donorsMap.addMarker(marker);
            
            //donorsMap.setCenter(results[0].geometry.location);
        /*    var marker = new google.maps.Marker({
              map: donorsMap,
              position: results[0].geometry.location
            });
            */
          } else {
            //alert('Geocode was not successful for the following reason: ' + status);
          }
        });
        
    });

 
}

var donorsTab = new Ext.Panel({
        title: '<?= __("Donors");?>',
        glyph: 'xf043@FontAwesome',
        cls: 'myTitleClass',
        layout: 'fit',
         
       
        items:[
            donorsGrid,
            {
            xtype:'button',
            margin: '20 0 0 20',
            text:"<?=__('Create');?>",
            glyph:'xf067@FontAwesome',
            handler:function(){
                var donorEditWindow = Ext.create('Ext.window.Window',{
                    title:"<?=__('Create new donor');?>",
                    width: 300,
                    items: [{
                        xtype:"form",
                        id:"donorDataForm",
                        defaults: {
                            xtype:'textfield',
                            padding: "10 10 0 10",
                            allowBlank: false
                        },
                        items:[{
                            fieldLabel:"<?=__('Name');?>",
                            name: 'Donor.name'    
                        },{
                            name:'Donor.address',
                            fieldLabel:"<?=__('Address');?>",
                        },{
                            name:"Donor.contact_name",
                            fieldLabel:"<?=__('Contact name');?>"
                        },{
                            name:"Donor.contact_number",
                            fieldLabel:"<?=__('Contact number');?>"
                        },{
                            name:'Donor.contact_mail',
                            fieldLabel:"<?=_('Contact mail');?>"
                            
                        },{
                            xtype:'combobox',
                            name:"Donor.gender",
                            fieldLabel:"<?=__('Gender');?>",
                            displayField:'name',
                            valueField:'abbr',
                            store: genderStore
                        },{
                            name:"Donor.date_of_birth",
                            fieldLabel:"<?=__('Date of birth');?>",
                            xtype: 'datefield',
                            format:'d.m.Y',
                        }],
                        buttons:[{
                            formBind: true,
                            text:"<?=__('Save');?>",
                            handler: function(){
                                donorEditWindow.items.get('donorDataForm').getForm().submit({
                                    url: '/donors/edit',
                                    success: function (form, action) {
                                        Ext.Msg.alert("<?=__('Saved');?>", action.result.message);
                                        donorsStore.load();  
                                        donorEditWindow.close();
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

               // donorEditWindow.items.get('donorDataForm').getForm().loadRecord(record);
                donorEditWindow.show();
            }
        
}
        ]
    });
    
function createAction(btn,title){
  
   if (btn == 'ok'){
       var data = donorsStore.getRange();
       var donor_ids = [];
       donorsStore.each(function(record){
          // console.log(record['data']['Donor']['id']);
           donor_ids.push(record['data']['Donor']['id']);
       });
        Ext.Ajax.request({
            url:'/events/createEvent',
            scope:this,
            params:{
                donor_ids: Ext.encode(donor_ids),
                event_title : title
            },
            success:function(response,c){
                var r = Ext.decode(response.responseText);

                if(r.success !== 'false'){
                   
                }

                
            },
            failure:function() {
               
            }
        });
   } else {
       
   }
   
}