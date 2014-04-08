$(document).ready(function(){
  showError();
  optWidth=27;
  optHeight=32;
  optgapX=20;
  optgapY=21;
  pageHeight=3300;
  maxAccurecy=15;
  minAccurecy=16;
})


function showError(err){
  // $(".error-box .container p").text(err);
  // $(".error-box").slideDown();
  if(!$(".error-box").hasClass("hide")){
    setTimeout(function(){
      $(".error-box").slideUp();
    }, 5000);
  }
}


function saveOmrSheet(sheetName, subPattern, subNo, subNames, subQsDist, colQsPattern, markingPattern, rollDigit, qOpts){
  console.log("kk");
  $.ajax({
    url:'scripts/saveomrsheet.php',
    type:'GET',
    data:{sheet_name:sheetName, sub_pattern:subPattern, sub_pattern:subPattern, sub_no:subNo, sub_names:subNames, sub_qs_dist:subQsDist, col_qs_pattern:colQsPattern, marking_pattern:markingPattern, roll_digit:rollDigit, q_opts:qOpts},
    success:function(data){
      if(data=="success"){
        $('.saveOption').hide();
        window.print();
        window.location.href="./create-omrsheet.php?msg=OMR Sheet saved successfully!&msg_clr=green";
      }else{
        alert(data);
      }
    }
  })
}
function saveOmrSheetDrn(sheetName, subPattern, mcqs, markingPattern, subQpattern){
  $.ajax({
    url:'scripts/saveomrsheetDrn.php',
    type:'GET',
    data:{sheet_name:sheetName, sub_pattern:subPattern, mcqs:mcqs, mcqm:0, compq:0, matrixq:0, digitq:0, marking_pattern:markingPattern, sub_q_pattern:subQpattern},
    success:function(data){
      if(data=="success"){
        $('.saveOption').hide();
        window.print();
        window.location.href="./create-omrsheet.php?msg=OMR Sheet saved successfully!&msg_clr=green";
      }else{
        alert(data);
      }
    }
  })
}