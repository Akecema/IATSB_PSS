/*// Add Record
function addRecord() {
    // get values
    var obj = $("#obj").val();
    var kra = $("#kra").val();
    var kpi = $("#kpi").val();



	if(obj == '' ){
		alert('Strategic Objective is required.');
		document.getElementById("obj").focus();
		document.getElementById('obj').style.borderColor = "#D41F3A";
		return false;
	}else if(kra == '' ){
		alert('Key Result Area is required.');
		document.getElementById("kra").focus();
		document.getElementById('kra').style.borderColor = "#D41F3A";
		return false;
	}else if(kpi == '' ){
		alert('Key Result Performance Indicators is required.');
		document.getElementById("kpi").focus();
		document.getElementById('kpi').style.borderColor = "#D41F3A";
		return false;
	}
	else
	{
		if (confirm('Are you sure you want to add this item?')){
			// Add record
			$.post("ippAdds1.php?e_id=<?php echo $stid; ?>&&p_id=<?php echo $prd; ?>", {
				obj: obj,
				kra: kra,
				kpi: kpi
			}, function (data, status) {
				alert('Your item added successfully.');
				location.reload();
				// close the popup
				$("#add_new_record_modal").modal("hide");
		
				// read records again
				readRecords();
		
				// clear fields from the popup
				$("#obj").val("");
				$("#kra").val("");
				$("#kpi").val("");
			});
		}
	}
	
}*/

// READ records
/*function readRecords() {
    $.get("readipp.php", {}, function (data, status) {
        $(".records_content").html(data);
    });
}
*/
function DeleteUser(id) {
    var conf = confirm("Are you sure, do you really want to delete User?");
    if (conf == true) {
        $.post("deleteUser.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

/*function GetUserDetails(id) {
    // Add User ID to the hidden field for furture usage
    $("#hidden_ipp_id").val(id);
    $.post("ippDetailss1.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_obj").val(user.obj);
            $("#update_kra").val(user.kra);
            $("#update_kpi").val(user.kpi);
        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}*/

function UpdateUserDetails() {
    // get values
    var obj = $("#update_obj").val();
    var kra = $("#update_kra").val();
    var kpi = $("#update_kpi").val();

    // get hidden field value
    var id = $("#hidden_ipp_id").val();

	if (obj == '') {
		alert('Strategic Objective is required.');
		document.getElementById("obj").focus();
		document.getElementById('obj').style.borderColor = "#D41F3A";
		return false;
	}
	else
	{
		if (confirm('Are you sure you want to edit this item?')) {
			// Update the details by requesting to the server using ajax
			$.post("updateUserDetails.php", {
					id: id,
					obj: obj,
					kra: kra,
					kpi: kpi
				},
				function (data, status) {
					alert('Your item update successfully.');
					// hide modal popup
					$("#update_user_modal").modal("hide");
					// reload Users by using readRecords();
					readRecords();
				}
			);
		}
	}
}

/*$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
});*/