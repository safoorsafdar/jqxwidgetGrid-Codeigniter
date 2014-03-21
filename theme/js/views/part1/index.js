var gridID = "allCustomers";
var path = base_url+'index.php/part1/allGrid';
/*
 * ***************************************************************
 * Definations
 * ***************************************************************
 */
/*
 * function for get Grid data adapter
 */
function getAdapter() {
    var source ={
        datatype: "json",
        datafields: [
            { name: 'CustomerID'},
            { name: 'EmailAddress'},
            { name: 'UserName'},
            { name: 'BillingFirstName'},
            { name: 'BillingLastName'},
            { name: 'BillingPostcode'},
            { name: 'Billingtelephone'},
            { name: 'Active'}
        ],
        sortcolumn: 'CustomerID',
        sortdirection: 'DESC',
        cache: false,
        url: path,
        filter: function(){
            $("#"+gridID).jqxGrid('updatebounddata', 'filter');
        },
        sort: function(){
         $("#"+gridID).jqxGrid('updatebounddata', 'sort');
        },
        root: 'Rows',
        beforeprocessing: function(data){		
            if (data != null){
                source.totalrecords = data[0].TotalRows;					
            }
        }
    };
    var dataAdapter = new $.jqx.dataAdapter(source, {
        loadError: function(xhr, status, error){
            alert(error);
        }
    });
    return dataAdapter;
}//End:getAdapter()
/*
 * ***************************************************************
 * Implementaions
 * ***************************************************************
 */
$(document).ready(function () {
    var editRenderer = function (row, datafield, value, defaultHtml, columnSettings, rowData) {return '<a href="#" class="tooltipT"  title="Click to Edit." style="margin-left:5px;position:relative; top:5px">Edit</a>';}
    var deleteRenderer = function (row, datafield, value, defaultHtml, columnSettings, rowData) {return '<a href="#"  style="margin-left: 5px;" title="Click to Delete.">Delete</a>';}
    var statusRenderer = function (row, datafield, value, defaultHtml, columnSettings, rowData) {
        var str_status = ""; 
        if(rowData.Active ===  "1"){
            str_status = 'Deactive';
            return '<a href="javascript:void(0);" onclick="#" style="margin-left:5px;" class="status" title="Click to Deactivate.">'+str_status+'</a>';
        }else{
            str_status = 'Active';
            return '<a href="javascript:void(0);"  onclick="#" style="margin-left:5px;" class="status" title="Click to Activate.">'+str_status+'</a>';
        }
    }
    $("#"+gridID).jqxGrid({
        width: '100%',
        source: getAdapter(),
        theme: 'default',
        pageable: true,
        pagesize:20,
        pagesizeoptions: ['20', '40', '60','100'],
        autoheight: true,
        sortable: true,
        altrows: true,
        enabletooltips: true,
        filterable: true,
        showfilterrow: true,
        virtualmode: true,
        enablehover: true,
//        selectionmode: 'checkbox',
        showstatusbar: true,
        rendergridrows: function(obj){
            return obj.data;    
        },
        renderstatusbar: function (statusbar) {
            // appends buttons to the status bar.
            var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
            var reloadButton = $("<div style='float: left; margin-left: 5px;'><button type='button' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-refresh'></span> Reload</button></div>");
            var clearButton = $("<div style='float: left; margin-left: 5px;'><button type='button' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-filter'></span>Clear</button></div>");
            container.append(reloadButton);
            container.append(clearButton);
            statusbar.append(container);
            //reloadButton.jqxButton({ theme: theme, width: 65 });
            // reload grid data.
            reloadButton.click(function (event) {
                //alert("stoper here");
                $("#"+gridID).jqxGrid({ source: getAdapter() });
                //$("#"+gridID).jqxGrid('sortby', 'OrderNumber', 'desc');
            });
            clearButton.click(function (event) {
                $("#"+gridID).jqxGrid('clearfilters');
            });
        },
        columns: [
            { text: 'Customer ID', datafield: 'CustomerID', columngroup: 'CustomersDetail',width:'100',filtercondition: 'starts_with'},
            { text: 'Email', datafield: 'EmailAddress',columngroup: 'CustomersDetail', width:'220', filtercondition: 'starts_with'},
            { text: 'User Name', datafield: 'UserName',columngroup: 'CustomersDetail', filtercondition: 'starts_with'},
            { text: 'Billing First Name', datafield: 'BillingFirstName',columngroup: 'CustomersDetail', filtercondition: 'starts_with'},
            { text: 'Billing Last Name', datafield: 'BillingLastName',columngroup: 'CustomersDetail', filtercondition: 'starts_with'},
            { text: 'Billing Postcode', datafield: 'BillingPostcode',columngroup: 'CustomersDetail', filtercondition: 'starts_with'},
            { text: 'Billing Telephone', datafield: 'Billingtelephone',columngroup: 'CustomersDetail', filtercondition: 'starts_with'},
            { text: 'Edit',cellsalign: 'center',filterable: false,sortable: false,columngroup: 'Action',cellsrenderer: editRenderer, width:'60',cellsalign: 'center'},
            { text: 'Delete',cellsalign: 'center',filterable: false,sortable: false,align: 'center',columngroup: 'Action',cellsrenderer: deleteRenderer, width:'60',cellsalign: 'center'},
            { text: 'Status',cellsalign: 'center',filterable: false,sortable: false ,align: 'center',columngroup: 'Action',cellsrenderer: statusRenderer, width:'100',cellsalign: 'center'},
        ],
        columngroups: [
            { text: 'Customer Detail', align: 'center', name: 'CustomersDetail'},
            { text: 'Actions', align: 'center', name: 'Action' }
        ]
    });
});
