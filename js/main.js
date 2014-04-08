$(document).ready(function(){
	if(!$(".error-box").hasClass("hide")){
		setTimeout(function(){
			$(".error-box").slideUp();
		}, 5000);
	}

	$("#searchName").click(function(){
		$("#batch-form").addClass("hide");
		$("#roll-form").addClass("hide");
		$("#name-form").removeClass("hide");
		$('#searchBatch').removeClass("hide");
		$('#searchRoll').removeClass("hide");
		$('#searchName').addClass("hide");
	});
	$("#searchRoll").click(function(){
		$("#batch-form").addClass("hide");
		$("#name-form").addClass("hide");
		$("#roll-form").removeClass("hide");
		$('#searchBatch').removeClass("hide");
		$('#searchRoll').addClass("hide");
		$('#searchName').removeClass("hide");
	});
	$("#searchBatch").click(function(){
		$("#roll-form").addClass("hide");
		$("#name-form").addClass("hide");
		$("#batch-form").removeClass("hide");
		$('#searchBatch').addClass("hide");
		$('#searchRoll').removeClass("hide");
		$('#searchName').removeClass("hide");
	});
	
})
function deleteRow(tableName, where, val){
	var ask=confirm("Are you sure to delete this??");
	if(ask==true){
		$.ajax({
			url:'./scripts/sql-js.php',
			type:'POST',
			data:{type:'delete', table_name:tableName, where:where, val:val},
			success:function(data){
				if(data=='success'){
					alert("Action has been comeleted succesfully! Now refresh the page for changes!");
				}else{
					alert(data);
				}
			}
		})
	}
}
function showError(err){
  // $(".error-box .container p").text(err);
  // $(".error-box").slideDown();
  if(!$(".error-box").hasClass("hide")){
    setTimeout(function(){
      $(".error-box").slideUp();
    }, 5000);
  }
}

function printPage(){
	$(".printHide").addClass("hide");
	print();
	$(".printHide").removeClass("hide");


}
function goto(link){
	window.location.href=link;
}
function hideTest(testId){
	$.ajax({
		url:'./scripts/hide-test.php',
		type:'POST',
		data:{test_id:testId},
		success:function(data){
			if(data=='success'){
				window.location.href="./all-tests.php";
			}else{
				alert("Sorry! There is an error! Please try again later");
			}
		}
	})
}
