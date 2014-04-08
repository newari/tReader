function setBasicVars(omrInfo){
    var omrInfoArr=JSON.parse(omrInfo);
    mcqsQs=omrInfoArr[0];
    mcqmQs=omrInfoArr[1];
    compQs=omrInfoArr[2];
    digit1Qs=omrInfoArr[3];
    matrixQs=omrInfoArr[4];
    digitQs=omrInfoArr[5];
    arQs=omrInfoArr[6];
    tfQs=omrInfoArr[7];
    q_opts=omrInfoArr[8];
    mcqsQsCa=0;
    mcqmQsCa=0;
    compQsCa=0;
    matrixQsCa=0;
    arQsCa=0;
    tfQsCa=0;
    if(q_opts!=5){
      q_opts=4;
    }

    mcqsQsCa=parseInt(mcqsQs/2)+mcqsQs%2;
    mcqmQsCa=parseInt(mcqmQs/2)+mcqmQs%2;
    compQsCa=parseInt(compQs/2)+compQs%2;
    matrixQsCa=parseInt(matrixQs/2)+matrixQs%2;
    if(digit1Qs>0){
      digit1QsCa=1;
    }else{
      digit1QsCa=0;
    }
    if(digitQs%3>0){
      digitQsCa=parseInt(digitQs/3)+1;
    }else{
      digitQsCa=parseInt(digitQs/3);
    }
    arQsCa=parseInt(arQs/2)+arQs%2;
    tfQsCa=parseInt(tfQs/2)+tfQs%2;
    totalBars=mcqsQsCa+mcqmQsCa+compQsCa+digit1QsCa+matrixQsCa+digitQsCa+arQsCa+tfQsCa;
    digitQsCa=1;

    optWidth=33;
    optLength=40; //////to get the option circle data for indexing
    optgapX=20;
    optgapXmatrix=20;

    rollDigitGapY=46.5;
    RowGapMatrix=47;
    rowGapDigit=47;

    maxAccurecy=22;
    minAccurecy=23;

    maxAccurecyVnone=22;
    minAccurecyVnone=23;
    maxAccurecyVwrong=20;
    minAccurecyVwrong=21;

    rollNoX=516;
    rollNoY=130;
    wrongRead=0;
   
}

function setsheetVars(){

}

function startEvaluation(){
  omrFolder=$("#omrFolder").val();
  testId=$('#testId').val()
  $(".folder-info").addClass("hide");
  $("#p1").text("Wait...");
  $.ajax({
    url:'./scripts/get-omrInfo.php',
    type:'POST',
    data:{test_id:testId},
    success:function(omrInfo){
      if(omrInfo!="error"){
        setBasicVars(omrInfo);
        $.ajax({
          url:"scripts/omrsheetlist.php",
          type:"POST",
          async:false,
          data:{folderName:omrFolder},
          success:function(data){
            var omrsArr=JSON.parse(data);
            totalsheets=omrsArr.length;
            var key=2;
            evaluationTimer=0;
            lastcX=0;
            lastcY=0;
            lastRotation=-1;
            evaluationTimer=setTimeout(evaluationLoop(omrsArr, key, totalsheets), 50);
          }
        });
      }else{
        alert("There is problem with your test ID.");
      }
    }

       
  })
  
}

function evaluationLoop(omrsArr, key, totalsheets){
    var ansdatastring="";
    var ansdata="";
    var omrSrc="scaned_omrs/"+omrFolder+"/"+omrsArr[key];
    if(omrsArr[key]!=undefined){
      var image=new Image();
      image.src=omrSrc;
      var can=document.getElementById('canvas1');
      var canvas=can.getContext("2d");
      $(image).load(function(){
        canvas.drawImage(image, 0, 0);
        setTimeout(function(){
          setSheet(canvas);
          if(cX==lastcX&&cY==lastcY&&rotationAngle==lastRotation){
              $("#p1").text("Checking has been stopped (Error-00401 !). Please refresh page and start again for remainig sheets.Hint: remove SHEET "+omrSrc+" and start again!"); 
              $(".analyz-option").html('<h5>Evaluation has been finished due to sheet Problems.</h5> <div class="alignC"><a href="./view-result.php?test_id='+testId+'&report=whole"><button class="btn btn-success">View Result!</button></a></div>'); 
              $(".analyz-option").removeClass("hide");
          }else{
              lastcX=cX;
              lastcY=cY;
              lastRotation=rotationAngle;
              setTimeout(function(){
                if(cX!=0){
                    var stdRollNo=getRollNo(canvas);
                    setTimeout(function(){
                      console.log(xes.length);
                      if(xes!=false&&xes.length==21){
                        ansdata=getResult(canvas);
                        setTimeout(function(){
                            if(wrongRead>2){
                                $('.non-checked').append("<p>"+omrsArr[key]+"</p>");
                                key+=1;
                                if(key==totalsheets){
                                    clearTimeout(evaluationTimer);
                                    $(".pb-window").addClass("hide");
                                    $(".analyz-option").html('<h5>Congratulation! Evaluation has been finished.</h5> <div class="alignC"><a href="./view-result.php?test_id='+testId+'&report=whole"><button class="btn btn-success">View Result!</button></a></div>'); 
                                    $(".analyz-option").removeClass("hide");
                                }else{
                                    evaluationTimer=setTimeout(evaluationLoop(omrsArr, key, totalsheets), 100);
                                } 
                            }else{
                                ansdata['rollNo']=stdRollNo;
                                ansdata['testId']=testId;
                                ansdata['omr_src']=omrSrc;
                                ansdatastring=JSON.stringify(ansdata);
                                $.ajax({
                                    url:'./scripts/store_testdata.php',
                                    type:'POST',
                                    async:false,
                                    data:{test_data:ansdatastring},
                                    success:function(data){
                                        console.log(data);
                                        $("#p1").text((key-1) +" -Sheets has been evaluated...");
                                        key+=1;
                                        cX=0;
                                        if(key==totalsheets){
                                          clearTimeout(evaluationTimer);
                                          $(".pb-window").addClass("hide");
                                          $(".analyz-option").html('<h5>Congratulation! Evaluation has been finished.</h5> <div class="alignC"><a href="./view-result.php?test_id='+testId+'&report=whole"><button class="btn btn-success">View Result!</button></a></div>'); 
                                          $(".analyz-option").removeClass("hide");
                                        }else{
                                          evaluationTimer=setTimeout(evaluationLoop(omrsArr, key, totalsheets), 100);
                                        } 
                                    }
                                });
                            }
                          }, 500);
                      }else{
                        $('.non-checked').append("<p>"+omrsArr[key]+"</p>");
                          key+=1;
                          if(key==totalsheets){
                              clearTimeout(evaluationTimer);
                              $(".pb-window").addClass("hide");
                              $(".analyz-option").html('<h5>Congratulation! Evaluation has been finished.</h5> <div class="alignC"><a href="./view-result.php?test_id='+testId+'&report=whole"><button class="btn btn-success">View Result!</button></a></div>'); 
                              $(".analyz-option").removeClass("hide");
                          }else{
                              evaluationTimer=setTimeout(evaluationLoop(omrsArr, key, totalsheets), 100);
                          } 
                      }


                  }, 500);
                }else{
                  $("#p1").text("Checking has been stopped (Error-00541 !). Please refresh page and start again for remainig sheets."); 
                  $(".analyz-option").html('<h5>Evaluation has been finished due to sheet Problems.</h5> <div class="alignC"><a href="./view-result.php?test_id='+testId+'&report=whole"><button class="btn btn-success">View Result!</button></a></div>'); 
                  $(".analyz-option").removeClass("hide");
                }

              }, 500)
          }
        }, 500)
      })
    }else{
         key+=1;
         evaluationTimer=setTimeout(evaluationLoop(omrsArr, key, totalsheets), 100);
    }
}

function startASevaluation(){
  $('.main-div').addClass("hide");
  $('.load-pv').removeClass("hide");
  rollNo="admin";
  testId=$("#testId").val();
  $.ajax({
    url:'./scripts/get-omrInfo.php',
    type:'POST',
    data:{test_id:testId},
    success:function(omrInfo){{
        if(omrInfo!="error"){
            var filePath=$("#answersheet").val();
            var fileName=filePath.replace(/^.*[\\\/]/, '');
            setOmrImage("answersheets/"+fileName);
            setTimeout(function(){
                setBasicVars(omrInfo);
                setTimeout(function(){
                  var sheetSet=setSheet(canvas);
                  if(sheetSet==true){
                      setTimeout(function(){
                          var ansdata=getResult(canvas);
                          var ansdatastring=JSON.stringify(ansdata);
                          $("#ansdata").val(ansdatastring);
                          $("#test_id").val(testId);
                          $('.pv-option').removeClass("hide");
                          $('.load-pv').addClass("hide");
                      },1000);
                  }else{
                    alert("Tilted Sheet. Try again after re-scan.");
                  }
                }, 1000)
              
              
            }, 2000) 
        }else{
          alert("Error! Please create test first with relative OMR Template!");
        }
    }}
  })
}

function setOmrImage(_omrSrc){
  var can=document.getElementById('canvas1');
  canvas=can.getContext("2d");
  var image=new Image();
  image.src=_omrSrc;
  $(image).load(function(){
    canvas.drawImage(image, 0, 0);
    return(true);
  })
}

function findCorner(canvas, startX, startY, w, h){
  var cornerData=canvas.getImageData(startX, startY, w, h);
  var cornerPixArr=cornerData.data;
  
  var accurecy=0;

  outer_loop:
  for(var index=0; index<w*h; index++){
    if(cornerPixArr[index*4]<120){
      if(cornerPixArr[index*4+1]<120){
        if(cornerPixArr[index*4+2]<120){
          accurecy=accurecy+1;
          if(accurecy>25){
            var accurecy2=0;
            var index2=index-25;
            for(ind=index2; ind<index; ind++){
              if(cornerPixArr[ind*4]<120){
                if(cornerPixArr[ind*4+1]<120){
                  if(cornerPixArr[ind*4+2]<120){
                    accurecy2=accurecy2+1;
                    if(accurecy2>20){
                      fsPixindex=index2;
                      fsPixrow=fsPixindex/w;
                      fsPixrow=fsPixrow|0;

                      cornerX=startX+fsPixindex-(fsPixrow*w);
                      cornerY=startY+fsPixrow;
                      var tempY=cornerY+10;
                      var tempData=canvas.getImageData(startX, tempY, w, 1);
                      var tempPixArr=tempData.data;
                      tempAccurecy=0;
                      temp_loop:
                      for(var tempi=0; tempi<w; tempi++){
                        if(tempPixArr[tempi*4]<120){
                          if(tempPixArr[tempi*4+1]<120){
                            if(tempPixArr[tempi*4+2]<120){
                              tempAccurecy=tempAccurecy+1;
                              if(tempAccurecy>25){
                                var tempAccurecy2=0;
                                var tempi2=tempi-25;
                                for(ind=tempi2; ind<tempi; ind++){
                                  if(tempPixArr[ind*4]<120){
                                    if(tempPixArr[ind*4+1]<120){
                                      if(tempPixArr[ind*4+2]<120){
                                        tempAccurecy2=tempAccurecy2+1;
                                        if(tempAccurecy2>20){
                                          cornerX=tempi2+startX;
                                          break temp_loop;
                                        }else{
                                          tempAccurecy=tempAccurecy-1;
                                        }
                                      }
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                      
                      break outer_loop;   
                    }else{
                      accurecy=accurecy-1;
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }
  if(typeof cornerX==='undefined'){
     $("#p1").text("Error! Refresh page and try again or Problem with OMR Printing!");
    alert("Please refresh the page and try again or Change OMR Sheet.");

  }
  var newStartX=cornerX+20;
  var yLinedata=canvas.getImageData(newStartX, startY, 1, h);
  var yLinePixArr=yLinedata.data;
  var accurecy=0;
  outer_loop:
  for(var index=0; index<h; index++){
    if(yLinePixArr[index*4]<130){
      if(yLinePixArr[index*4+1]<130){
        if(yLinePixArr[index*4+2]<130){
          accurecy=accurecy+1;
          if(accurecy>25){
            var accurecy2=0;
            var index2=index-25;
            for(ind=index2; ind<index; ind++){
              if(yLinePixArr[ind*4]<130){
                if(yLinePixArr[ind*4+1]<130){
                  if(yLinePixArr[ind*4+2]<130){
                    accurecy2=accurecy2+1;
                    if(accurecy2>20){
                      fsPixindex=index2;
                      fsPixrow=fsPixindex;
                      cornerY=startY+fsPixrow;
                      
                      break outer_loop;   
                    }else{
                      accurecy=accurecy-1;
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }
  var cornerPosition={};
  cornerPosition['x']=cornerX;
  cornerPosition['y']=cornerY;
  return cornerPosition;
}

function setSheet(canvas){
  var corner1=findCorner(canvas, 50, 100, 200, 360);
  var corner2=findCorner(canvas, 2235, 100, 200, 360);
  cX=corner1.x;
  cY=corner1.y;
  cX2=corner2.x;
  cY2=corner2.y;
 
  if((corner2.y-corner1.y)>0){
    var tanThetaVal2=(corner2.y-corner1.y)/(corner2.x-corner1.x);
    rotation="clock";
    var lBarLineX=cX-10;
    var lBarLineXe=cX-15;
    var rBarLineX=cX2+15;
    var rBarLineXe=cX2+10;
  }else{
    var tanThetaVal2=-(corner2.y-corner1.y)/(corner2.x-corner1.x);
    rotation="antiClock";
    var lBarLineX=cX+10;
    var lBarLineXe=cX+15;
    var rBarLineX=cX2+55;
    var rBarLineXe=cX2+65;
  }
  xes=false;
  var tantheta=tanThetaVal2;
  rotationAngle=Math.atan(tantheta);
  rotationAngle=rotationAngle.toFixed(4);
  rotationAngle=parseFloat(rotationAngle);
  var lBarLineY=cY+100;
  var rBarLineY=cY2+100;
  barsY=new Array();

  barsY['left']=getBarsY(canvas, lBarLineX, lBarLineY);
  if(barsY['left'].length!=(totalBars+1)){
      barsY['left']=getBarsY(canvas, lBarLineXe, lBarLineY);
      if(barsY['left'].length==(totalBars+1)){
          barsY['right']=getBarsY(canvas, rBarLineX, rBarLineY);
          if(barsY['right'].length!=(totalBars+1)){
            barsY['right']=getBarsY(canvas, rBarLineXe, rBarLineY);
            if(barsY['right']!=(totalBars+1)){
              barsY['right']=false;
            }
          }
      }else{
        barsY['left']=false;
      }
  }else{
      barsY['right']=getBarsY(canvas, rBarLineX, rBarLineY);
      if(barsY['right'].length!=(totalBars+1)){
        barsY['right']=getBarsY(canvas, rBarLineXe, rBarLineY);
        if(barsY['right']!=(totalBars+1)){
          barsY['right']=false;
        }
      }
  }

  if(barsY['left']!=false&&barsY['right']!=false){
      barsX=new Array();
     barsX=getBarsX(canvas, barsY['left']);
     if(barsX.length!=(totalBars+1)){
        barsX=false;
     }
  }else{
    barsX=false;
  }

  if(barsX!=false){
    xes =new Array();
    xes=getXes(canvas, barsY['left'][totalBars], barsY['right'][totalBars], barsX[totalBars]);
    if(xes!=false&&(xes.length==21||xes.length==22)){
      return true;
    }
  }else{
    return false;
  }
  
}

function getBarsY(canvas, lBarLineX, lBarLineY){
  var lbarLineData=canvas.getImageData(lBarLineX, lBarLineY, 1, 2900);
  var lBarLinePixArr=lbarLineData.data;
  var barNo=0;
  var whiteLine=0;
  var blackLine=0;
  var barYs=new Array();
  for(var index=0; index<2900; index++){
    if(lBarLinePixArr[index*4]<130){
        if(lBarLinePixArr[index*4+1]<130){
            if(lBarLinePixArr[index*4+2]<130){
                blackLine++;
                whiteLine=0;
                if(blackLine>15){
                  barYs[barNo]=index-15+lBarLineY;
                  barNo++;
                  blackLine=0;
                }
            }else{
              whiteLine++;
            }
        }else{
            whiteLine++;
        }
    }else{
        whiteLine++;
    }
    if(whiteLine>3){
        blackLine=0;
    }
  }

    return barYs;
}

function getBarsX(canvas, barsYArr){
    var barsX=new Array();
    for(var barNo=0; barNo<=totalBars; barNo++){
        var barY=barsYArr[barNo]+5;
        var barX=cX-80;
        if(barX<5){
          barX=5;
        }
        var pixData=canvas.getImageData(barX, barY, 160, 1);
        var pixDataArr=pixData.data;
        var blackLine=0;
        for(var index=0; index<160; index++){
            if(pixDataArr[index*4]<130){
              if(pixDataArr[index*4+1]<130){
                  if(pixDataArr[index*4+2]<130){
                     blackLine++;
                     if(blackLine>10){
                        barsX[barNo]=index-10+barX;
                        break;
                     }
                  }
              }
            }
        }
    }
    return barsX;
}

function getXes(canvas, refYL, refYR, leftBarX){
    var dif=Math.abs(refYR-refYL);
    if(dif<36){
       if(refYL>refYR){
            var refY=refYL-17;
        }else if(refYL<refYR||refYL==refYR){
            var refY=refYL+17;
        }
        var x=leftBarX+100;
        var xlineData=canvas.getImageData(x, refY, 1950, 1);
        var xLineArr=xlineData.data;
        var blackLine=0;
        var whiteLine=0;
        var xes=new Array();
        var barNo=0;
        for(var index=0; index<1950; index++){
          if(xLineArr[index*4]<130){
              if(xLineArr[index*4+1]<130){
                  if(xLineArr[index*4+2]<130){
                      blackLine++;
                      whiteLine=0;
                      if(blackLine>10){
                        xes[barNo]=index-10+100;
                        barNo++;
                        blackLine=0;
                      }
                  }else{
                    whiteLine++;
                  }
              }else{
                  whiteLine++;
              }
          }else{
              whiteLine++;
          }
          if(whiteLine>3){
              blackLine=0;
          }
        }
    }else{
     var xes=false;
    }
    return xes;
}

function newPosition(angle, dir, x, y){
  var tantheta=-y/x;
  var newTheta=Math.atan(tantheta);
  var r=Math.sqrt(x*x+y*y);
  if(dir=="antiClock"){
    var rightTheta=(newTheta)+(angle);
  }else{
    var rightTheta=newTheta-angle;
  }

  
  var cosTheta=Math.cos(rightTheta);
  // var sinTheta=Math.sin(rightTheta);
  var newX=r*cosTheta|0;
  // var newY=-r*sinTheta|0;
  var newPositionSet={"x":newX, "y":y};
  return newPositionSet;
}

function getMcqsAns(canvas, qXstart, qYstart){

  var ansFind="no";
  var filledOpt=0;
  for(var opt=0; opt<q_opts; opt++){
    var optAccurecy=0;
    var optX=qXstart+optWidth*opt+optgapX*opt-5;
    var optY=qYstart;
    var optImgData=canvas.getImageData(optX, optY, optLength, 1);
    var optPixArr=optImgData.data;
    
    var optAccurecyV=0;
    var optXV=optX+5+(optWidth/2|0);
    var optYV=optY-5-(optWidth/2|0);
    var optImgDataV=canvas.getImageData(optXV, optYV, 1, optLength);
    var optPixArrV=optImgDataV.data;
    for(var index=0; index<optLength; index++){
      if(optPixArr[index*4]<140){
        if(optPixArr[index*4+1]<140){
          if(optPixArr[index*4+1]<140){
            optAccurecy=optAccurecy+1;  
            if(optAccurecy>22){
              var tempAcc=0
              var newIndex =index-23;
              for(var tempInd=0; tempInd<23; tempInd++){
                if(optPixArr[index*4]<140){
                  if(optPixArr[index*4+1]<140){
                    if(optPixArr[index*4+1]<140){
                      tempAcc++;
                    }
                  }
                }
              }
              if(tempAcc>20){
                optAccurecy=25;
                break;
              }else{
                optAccurecy=tempAcc;
              }
            }
          }
        }
      }
    }
    drawLine(canvas, optX, optY, 10, 1);
    if(optAccurecy>maxAccurecy){
      if(ansFind=="no"){
        ansFind="yes";
        filledOpt=opt+1;

      }else{
        filledOpt="more";
        break;
      }
      
    }else {
      for(var index=0; index<optLength; index++){
        if(optPixArrV[index*4]<140){
          if(optPixArrV[index*4+1]<140){
            if(optPixArrV[index*4+1]<140){
              optAccurecyV=optAccurecyV+1;  
              if(optAccurecyV>22){
                var tempAcc=0
                var newIndex =index-23;
                for(var tempInd=0; tempInd<23; tempInd++){
                  if(optPixArrV[index*4]<140){
                    if(optPixArrV[index*4+1]<140){
                      if(optPixArrV[index*4+1]<140){
                        tempAcc++;
                      }
                    }
                  }
                }
                if(tempAcc>20){
                  optAccurecyV=25;
                  break;
                }else{
                  optAccurecyV=tempAcc;
                }
              }
            }
          }
        }
      }
    drawLine(canvas, optXV, optYV, 1, 10);

      if(optAccurecy<minAccurecy){
        if(optAccurecyV>maxAccurecyVnone){
          if(ansFind=="no"){
            ansFind="yes";
            filledOpt=opt+1;

          }else{
            filledOpt="more";
            break;
          }
        }else if(optAccurecyV<minAccurecyVnone){
          continue;
        }else{
          filledOpt="wrong";
          wrongRead++;
          ansFind="yes";
          break
        }
      }else{
        if(optAccurecyV>maxAccurecyVwrong){
          if(ansFind=="no"){
            ansFind="yes";
            filledOpt=opt+1;

          }else{
            filledOpt="more";
            break;
          }
        }else if(optAccurecyV<minAccurecyVwrong){
          continue;
        }else{
          filledOpt="wrong";
          wrongRead++;
          ansFind="yes";
          break
        }
        
      }
    }
    
    
    
  }
  if(ansFind=="no"){
    filledOpt="blank";
  }else if(ansFind=="yes"&&filledOpt!="wrong"&&filledOpt!="more"){
    // var drawX=(optWidth+optgapX)*(filledOpt-1)+qXstart;
    // var drawY=qYstart-(optHeight/2|0);
    // drawOutline(canvas, drawX, drawY, optWidth);
    
  }

  return(filledOpt);
}

function getMcqmAns(canvas, qXstart, qYstart){
  var filledOpt=new Array();
  var ansFind="no";
  for(var opt=0; opt<4; opt++){
    var optAccurecy=0;
    var optX=qXstart+optWidth*opt+optgapX*opt-5;
    var optY=qYstart;
    var optImgData=canvas.getImageData(optX, optY, optLength, 1);
    var optPixArr=optImgData.data;

    var optAccurecyV=0;
    var optXV=optX+5+(optWidth/2|0);
    var optYV=optY-5-(optWidth/2|0);
    var optImgDataV=canvas.getImageData(optXV, optYV, 1, optLength);
    var optPixArrV=optImgDataV.data;
    for(var index=0; index<optLength; index++){
      if(optPixArr[index*4]<140){
        if(optPixArr[index*4+1]<140){
          if(optPixArr[index*4+1]<140){
            optAccurecy=optAccurecy+1;  
            if(optAccurecy>22){
              var tempAcc=0
              var newIndex =index-23;
              for(var tempInd=0; tempInd<23; tempInd++){
                if(optPixArr[index*4]<140){
                  if(optPixArr[index*4+1]<140){
                    if(optPixArr[index*4+1]<140){
                      tempAcc++;
                    }
                  }
                }
              }
              if(tempAcc>20){
                optAccurecy=25;
                break;
              }else{
                optAccurecy=tempAcc;
              }
            }
          }
        }
      }
    }
    drawLine(canvas, optX, optY, 10, 1);

    if(optAccurecy>maxAccurecy){
        filledOpt.push(opt+1);
        ansFind="yes";

    }else {
      for(var index=0; index<optLength; index++){
        if(optPixArrV[index*4]<140){
          if(optPixArrV[index*4+1]<140){
            if(optPixArrV[index*4+1]<140){
              optAccurecyV=optAccurecyV+1;  
              if(optAccurecyV>22){
                var tempAcc=0
                var newIndex =index-23;
                for(var tempInd=0; tempInd<23; tempInd++){
                  if(optPixArrV[index*4]<140){
                    if(optPixArrV[index*4+1]<140){
                      if(optPixArrV[index*4+1]<140){
                        tempAcc++;
                      }
                    }
                  }
                }
                if(tempAcc>20){
                  optAccurecyV=25;
                  break;
                }else{
                  optAccurecyV=tempAcc;
                }
              }
            }
          }
        }
      }
    drawLine(canvas, optXV, optYV, 1, 10);

      if(optAccurecy<minAccurecy){
        if(optAccurecyV>maxAccurecyVnone){
          filledOpt.push(opt+1);
          ansFind="yes";
        }else if(optAccurecyV<minAccurecyVnone){
          continue;
        }else{
          filledOpt.push("wrong");
          wrongRead++;
          ansFind="yes";
        }
      }else{
        if(optAccurecyV>maxAccurecyVwrong){
          filledOpt.push(opt+1);
          ansFind="yes";
        }else if(optAccurecyV<minAccurecyVwrong){
          continue;
        }else{
          filledOpt.push("wrong");
          wrongRead++;
          ansFind="yes";
        }
      }
    }
  }
  if(ansFind=="no"){
    filledOpt[0]="blank";
    
  }else if(ansFind=="yes"&&filledOpt.indexOf("wrong")==-1){
    // $.each(filledOpt, function(index, option){
    //   // var drawX=(optWidth+optgapX)*(option-1)+qXstart;
    //   // var drawY=qYstart-optHeight/2|0;
    //   // drawOutline(canvas, drawX, drawY, optWidth);
    // })
    
  }


  return(filledOpt);
}

function getCompqAns(canvas, qXstart, qYstart){
  var ansFind="no";
  var filledOpt=0;
  for(var opt=0; opt<4; opt++){
    var optAccurecy=0;
    var optX=qXstart+optWidth*opt+optgapX*opt-5;
    var optY=qYstart;
    var optImgData=canvas.getImageData(optX, optY, optLength, 1);
    var optPixArr=optImgData.data;

    var optAccurecyV=0;
    var optXV=optX+5+(optWidth/2|0);
    var optYV=optY-5-(optWidth/2|0);
    var optImgDataV=canvas.getImageData(optXV, optYV, 1, optLength);
    var optPixArrV=optImgDataV.data;
    for(var index=0; index<optLength; index++){
      if(optPixArr[index*4]<140){
        if(optPixArr[index*4+1]<140){
          if(optPixArr[index*4+1]<140){
            optAccurecy=optAccurecy+1;  
            if(optAccurecy>22){
              var tempAcc=0
              var newIndex =index-23;
              for(var tempInd=0; tempInd<23; tempInd++){
                if(optPixArr[index*4]<140){
                  if(optPixArr[index*4+1]<140){
                    if(optPixArr[index*4+1]<140){
                      tempAcc++;
                    }
                  }
                }
              }
              if(tempAcc>20){
                optAccurecy=25;
                break;
              }else{
                optAccurecy=tempAcc;
              }
            }
          }
        }
      }
    }
    drawLine(canvas, optX, optY, 10, 1);
    if(optAccurecy>maxAccurecy){
      if(ansFind=="no"){
        ansFind="yes";
        filledOpt=opt+1;

      }else{
        filledOpt="more";
        break;
      }
      
    }else {
      for(var index=0; index<optLength; index++){
        if(optPixArrV[index*4]<140){
          if(optPixArrV[index*4+1]<140){
            if(optPixArrV[index*4+1]<140){
              optAccurecyV=optAccurecyV+1;  
              if(optAccurecyV>22){
                var tempAcc=0
                var newIndex =index-23;
                for(var tempInd=0; tempInd<23; tempInd++){
                  if(optPixArrV[index*4]<140){
                    if(optPixArrV[index*4+1]<140){
                      if(optPixArrV[index*4+1]<140){
                        tempAcc++;
                      }
                    }
                  }
                }
                if(tempAcc>20){
                  optAccurecyV=25;
                  break;
                }else{
                  optAccurecyV=tempAcc;
                }
              }
            }
          }
        }
      }
      drawLine(canvas, optXV, optYV, 1, 10);
      if(optAccurecy<minAccurecy){
        if(optAccurecyV>maxAccurecyVnone){
          if(ansFind=="no"){
            ansFind="yes";
            filledOpt=opt+1;

          }else{
            filledOpt="more";
            break;
          }
        }else if(optAccurecyV<minAccurecyVnone){
          continue;
        }else{
          filledOpt="wrong";
          wrongRead++;
          ansFind="yes";
          break
        }
      }else{
        if(optAccurecyV>maxAccurecyVwrong){
          if(ansFind=="no"){
            ansFind="yes";
            filledOpt=opt+1;

          }else{
            filledOpt="more";
            break;
          }
        }else if(optAccurecyV<minAccurecyVwrong){
          continue;
        }else{
          filledOpt="wrong";
          wrongRead++;
          ansFind="yes";
          break
        }
        
      }
    }
       
  }
  if(ansFind=="no"){
    filledOpt="blank";
  }else if(ansFind=="yes"&&filledOpt!="wrong"&&filledOpt!="more"){
    // var drawX=(optWidth+optgapX)*(filledOpt-1)+qXstart;
    // var drawY=qYstart-(optHeight/2|0);
    // drawOutline(canvas, drawX, drawY, optWidth);
    
  }

  return(filledOpt);
}

function getMatrixqAns(canvas, qXstart, qYstart){
  var filledOpt=new Array();
  var ans="blank";
  for(var row=0; row<4; row++){
    var ansFind="no";
    var ansSet=new Array();
    for(var opt=0; opt<5; opt++){
      var optAccurecy=0;
      var optX=qXstart+(optWidth)*opt+optgapXmatrix*opt-5;
      var optY=qYstart+(RowGapMatrix)*row;
      var optImgData=canvas.getImageData(optX, optY, optLength, 1);
      var optPixArr=optImgData.data;

      var optAccurecyV=0;
      var optXV=optX+5+(optWidth/2|0);
      var optYV=optY-5-(optWidth/2|0);
      var optImgDataV=canvas.getImageData(optXV, optYV, 1, optLength);
      var optPixArrV=optImgDataV.data;
      for(var index=0; index<optLength; index++){
          if(optPixArr[index*4]<140){
            if(optPixArr[index*4+1]<140){
              if(optPixArr[index*4+1]<140){
                optAccurecy=optAccurecy+1;  
                if(optAccurecy>22){
                  var tempAcc=0
                  var newIndex =index-23;
                  for(var tempInd=0; tempInd<23; tempInd++){
                    if(optPixArr[index*4]<140){
                      if(optPixArr[index*4+1]<140){
                        if(optPixArr[index*4+1]<140){
                          tempAcc++;
                        }
                      }
                    }
                  }
                  if(tempAcc>20){
                    optAccurecy=25;
                    break;
                  }else{
                    optAccurecy=tempAcc;
                  }
                }
              }
            }
          }
        }
    drawLine(canvas, optX, optY, 10, 1);
      if(optAccurecy>maxAccurecy){
          ans=opt+1;
          ansFind="yes";
          ansSet.push(ans);
      }else {
        for(var index=0; index<optLength; index++){
          if(optPixArrV[index*4]<140){
            if(optPixArrV[index*4+1]<140){
              if(optPixArrV[index*4+1]<140){
                optAccurecyV=optAccurecyV+1;  
                if(optAccurecyV>22){
                  var tempAcc=0
                  var newIndex =index-23;
                  for(var tempInd=0; tempInd<23; tempInd++){
                    if(optPixArrV[index*4]<140){
                      if(optPixArrV[index*4+1]<140){
                        if(optPixArrV[index*4+1]<140){
                          tempAcc++;
                        }
                      }
                    }
                  }
                  if(tempAcc>20){
                    optAccurecyV=25;
                    break;
                  }else{
                    optAccurecyV=tempAcc;
                  }
                }
              }
            }
          }
        }
    drawLine(canvas, optXV, optYV, 1, 10);
        if(optAccurecy<minAccurecy){
          if(optAccurecyV>maxAccurecyVnone){
            ans=opt+1;
            ansFind="yes";
            ansSet.push(ans);
          }else if(optAccurecyV<minAccurecyVnone){
            continue;
          }else{
            ans="wrong";
            ansFind='yes';
            ansSet.push(ans);
          }
        }else{
          if(optAccurecyV>maxAccurecyVwrong){
            ans=opt+1;
            ansFind="yes";
            ansSet.push(ans);
          }else if(optAccurecyV<minAccurecyVwrong){
            continue;
          }else{
            ans="wrong";
            ansFind='yes';
            ansSet.push(ans);
          }
        }
      }
    }
    if(ansFind=="no"){
      ansSet.push("blank");
    }else if(ans!="wrong"&&ansFind=="yes"&&ans!="more"){
        // var drawX=(optWidth+optgapX)*(ans-1)+qXstart;
        // var drawY=qYstart+(RowGapMatrix)*row-optHeight/2|0;
        // drawOutline(canvas, drawX, drawY, optWidth);
    }
    filledOpt.push(ansSet);
  }
  return(filledOpt)
}
function get1digitqAns(canvas, qXstart, qYstart){
  var ans="blank"
  var ansFind="no";
   
  main_loop:
  for(var col=0; col<1; col++){
      var ansFind="no";
      for(var opt=0; opt<10; opt++){
        var optAccurecy=0;
        var optX=qXstart-20;
        var optY=qYstart+(rowGapDigit)*opt;
        var optImgData=canvas.getImageData(optX, optY, optLength, 1);
        var optPixArr=optImgData.data;

        var optAccurecyV=0;
        var optXV=optX+5+(optWidth/2|0);
        var optYV=optY-5-(optWidth/2|0);
        var optImgDataV=canvas.getImageData(optXV, optYV, 1, optLength);
        var optPixArrV=optImgDataV.data;
        for(var index=0; index<optLength; index++){
          if(optPixArr[index*4]<140){
            if(optPixArr[index*4+1]<140){
              if(optPixArr[index*4+1]<140){
                optAccurecy=optAccurecy+1;  
                if(optAccurecy>22){
                  var tempAcc=0
                  var newIndex =index-23;
                  for(var tempInd=0; tempInd<23; tempInd++){
                    if(optPixArr[index*4]<130){
                      if(optPixArr[index*4+1]<130){
                        if(optPixArr[index*4+1]<130){
                          tempAcc++;
                        }
                      }
                    }
                  }
                  if(tempAcc>20){
                    optAccurecy=29;
                    break;
                  }else{
                    optAccurecy=tempAcc;
                  }
                }
              }
            }
          }
        }

        drawLine(canvas, optX, optY, 10, 1);
        if(optAccurecy>maxAccurecy){
            if(ansFind=="no"){
              ans=opt;
              ansFind="yes";
              // console.log(optAccurecy);

            }else{
              ans="more";
            }

        }else{
          for(var index=0; index<optLength; index++){
            if(optPixArrV[index*4]<140){
              if(optPixArrV[index*4+1]<140){
                if(optPixArrV[index*4+1]<140){
                  optAccurecyV=optAccurecyV+1;  
                  if(optAccurecyV>22){
                    var tempAcc=0
                    var newIndex =index-23;
                    for(var tempInd=0; tempInd<23; tempInd++){
                      if(optPixArrV[index*4]<130){
                        if(optPixArrV[index*4+1]<130){
                          if(optPixArrV[index*4+1]<130){
                            tempAcc++;
                          }
                        }
                      }
                    }
                    if(tempAcc>20){
                      break;
                    }else{
                      optAccurecyV=tempAcc;
                    }
                  }
                }
              }
            }
          }

          drawLine(canvas, optXV, optYV, 1, 10);
          if(optAccurecy<minAccurecy){
              if(optAccurecyV>maxAccurecyVnone){
                  if(ansFind=="no"){
                    ans=opt;
                    // console.log(optAccurecyV);
                    ansFind="yes";
                   }else{
                      // console.log(optAccurecyV+"more");
                      ans="more";
                    }
              }else if(optAccurecyV<minAccurecyVnone){

                continue;
              }else{
                ans="wrong";
                ansFind='yes';
              }
          }else{
              if(optAccurecyV>maxAccurecyVwrong){
                  if(ansFind=="no"){
                    ans=opt;
                    ansFind="yes";
                  }else{
                    ans="more";
                  }
              }else if(optAccurecyV<minAccurecyVwrong){
                continue;
              }else{
                ans="wrong";
                ansFind='yes';
              }
          }
        }
      
        
      }
      if(ansFind=="no"){
        ans="blank";
        
        // break main_loop;
      }else if(ans!="wrong"&&ansFind=="yes"&&ans!="more"){
          // var drawY=qYstart+(rowGapDigit)*(ans)-optWidth/2|0;
          // var drawX=qXstart+(optgapX+optWidth)*col|0;
          // drawOutline(canvas, drawX, drawY, optWidth);
      }
  }
  return(ans)
}


function get4digitqAns(canvas, qXstart, qYstart){
  var digitQboxH=barsY['left'][totalBars]-barsY['left'][(totalBars-1)]-5;
  rowGapDigit=digitQboxH/12;
  var filledOpt=new Array();
  var ans="blank"
  var ansFind="no";
  for(var signOpt=0; signOpt<2; signOpt++){
      var optAccurecy=0;
      
      var optX=qXstart+(optgapX+optWidth)*signOpt+98;
      var optY=qYstart-rowGapDigit;
      var optImgData=canvas.getImageData(optX, optY, optLength, 1);
      var optPixArr=optImgData.data;

      var optAccurecyV=0;
      var optXV=optX+(optWidth/2|0);
      var optYV=optY-5-(optWidth/2|0);
      var optImgDataV=canvas.getImageData(optXV, optYV, 1, optLength);
      var optPixArrV=optImgDataV.data;
      for(var index=0; index<optLength; index++){
          if(optPixArr[index*4]<140){
            if(optPixArr[index*4+1]<140){
              if(optPixArr[index*4+1]<140){
                optAccurecy=optAccurecy+1;  
                if(optAccurecy>22){
                  var tempAcc=0
                  var newIndex =index-23;
                  for(var tempInd=0; tempInd<23; tempInd++){
                    if(optPixArr[index*4]<130){
                      if(optPixArr[index*4+1]<130){
                        if(optPixArr[index*4+1]<130){
                          tempAcc++;
                        }
                      }
                    }
                  }
                  if(tempAcc>20){
                    optAccurecy=25;
                    break;
                  }else{
                    optAccurecy=tempAcc;
                  }
                }
              }
            }
          }
      }
      
      drawLine(canvas, optX, optY, 10, 1);
      if(optAccurecy>maxAccurecy){
        if(ansFind=="no"){
          ans=signOpt;
          ansFind="yes";
        }else{
          ans="more";
          // break main_loop;
        }
      }else{
        for(var index=0; index<optLength; index++){
            if(optPixArrV[index*4]<140){
              if(optPixArrV[index*4+1]<140){
                if(optPixArrV[index*4+1]<140){
                  optAccurecyV=optAccurecyV+1;  
                  if(optAccurecyV>22){
                    var tempAcc=0
                    var newIndex =index-23;
                    for(var tempInd=0; tempInd<23; tempInd++){
                      if(optPixArrV[index*4]<130){
                        if(optPixArrV[index*4+1]<130){
                          if(optPixArrV[index*4+1]<130){
                            tempAcc++;
                          }
                        }
                      }
                    }
                    if(tempAcc>20){
                      optAccurecyV=25;
                      break;
                    }else{
                      optAccurecyV=tempAcc;
                    }
                  }
                }
              }
            }
          }
    drawLine(canvas, optXV, optYV, 1, 10);
        if(optAccurecy<minAccurecy){
            if(optAccurecyV>maxAccurecyVnone){
              if(ansFind=="no"){
                ans=signOpt;
                ansFind="yes";
              }else{
                ans="more";
                // break main_loop;
              }
            }else if(optAccurecyV<minAccurecyVnone){
              continue;
            }else{
              if(ansFind=="no"){
                 ans="wrong";
              }else{
                ans=0;
              }
            }
        }else{
            if(optAccurecyV>maxAccurecyVwrong){
              if(ansFind=="no"){
                ans=signOpt;
                ansFind="yes";
              }else{
                ans="more";
                // break main_loop;
              }
            }else if(optAccurecyV<minAccurecyVwrong){
              continue;
            }else{
              if(ansFind=="no"){
                 ans="wrong";
              }else{
                ans=0;
              }
            }
         
          // break main_loop;
        }
      }
      
  }
  if(ansFind=="no"){
      ans="blank";
      
    }else if(ans!="wrong"&&ansFind=="yes"&&ans!="more"){
        // var drawX=qXstart+(optgapXO+optWidth)*ans+47;
        // var drawY=qYstart-optgapY-optWidth/2|0;
        // drawOutline(canvas, drawX, drawY, optWidth);
      
        if(ans==0){
          ans="+";
        }else if(ans==1){
          ans="-";
        }else{
          ans="blank";
        }
       
      
    }
    
    filledOpt.push(ans);
    
    main_loop:
    for(var col=0; col<4; col++){
      var ansFind="no";
      for(var opt=0; opt<11; opt++){
        var optAccurecy=0;
        var optX=qXstart+(optgapX+optWidth)*col-5;
        var optY=qYstart+(rowGapDigit)*opt;
        var optImgData=canvas.getImageData(optX, optY, optLength, 1);
        var optPixArr=optImgData.data;

        var optAccurecyV=0;
        var optXV=optX+5+(optWidth/2|0);
        var optYV=optY-5-(optWidth/2|0);
        var optImgDataV=canvas.getImageData(optXV, optYV, 1, optLength);
        var optPixArrV=optImgDataV.data;
        for(var index=0; index<optLength; index++){
          if(optPixArr[index*4]<140){
            if(optPixArr[index*4+1]<140){
              if(optPixArr[index*4+1]<140){
                optAccurecy=optAccurecy+1;  
                if(optAccurecy>22){
                  var tempAcc=0
                  var newIndex =index-23;
                  for(var tempInd=0; tempInd<23; tempInd++){
                    if(optPixArr[index*4]<130){
                      if(optPixArr[index*4+1]<130){
                        if(optPixArr[index*4+1]<130){
                          tempAcc++;
                        }
                      }
                    }
                  }
                  if(tempAcc>20){
                    optAccurecy=29;
                    break;
                  }else{
                    optAccurecy=tempAcc;
                  }
                }
              }
            }
          }
        }

    drawLine(canvas, optX, optY, 10, 1);
        if(optAccurecy>maxAccurecy){
            if(ansFind=="no"){
              ans=opt;
              ansFind="yes";
              // console.log(optAccurecy);

            }else{
              ans="more";
            }

        }else{
          for(var index=0; index<optLength; index++){
            if(optPixArrV[index*4]<140){
              if(optPixArrV[index*4+1]<140){
                if(optPixArrV[index*4+1]<140){
                  optAccurecyV=optAccurecyV+1;  
                  if(optAccurecyV>22){
                    var tempAcc=0
                    var newIndex =index-23;
                    for(var tempInd=0; tempInd<23; tempInd++){
                      if(optPixArrV[index*4]<130){
                        if(optPixArrV[index*4+1]<130){
                          if(optPixArrV[index*4+1]<130){
                            tempAcc++;
                          }
                        }
                      }
                    }
                    if(tempAcc>20){
                      break;
                    }else{
                      optAccurecyV=tempAcc;
                    }
                  }
                }
              }
            }
          }

    drawLine(canvas, optXV, optYV, 1, 10);
          if(optAccurecy<minAccurecy){
              if(optAccurecyV>maxAccurecyVnone){
                  if(ansFind=="no"){
                    ans=opt;
                    // console.log(optAccurecyV);
                    ansFind="yes";
                   }else{
                      // console.log(optAccurecyV+"more");
                      ans="more";
                    }
              }else if(optAccurecyV<minAccurecyVnone){

                continue;
              }else{
                ans="wrong";
                ansFind='yes';
              }
          }else{
              if(optAccurecyV>maxAccurecyVwrong){
                  if(ansFind=="no"){
                    ans=opt;
                    ansFind="yes";
                  }else{
                    ans="more";
                  }
              }else if(optAccurecyV<minAccurecyVwrong){
                continue;
              }else{
                ans="wrong";
                ansFind='yes';
              }
          }
        }
      
        
      }
      if(ansFind=="no"){
        ans="blank";
        
        // break main_loop;
      }else if(ans!="wrong"&&ansFind=="yes"&&ans!="more"){
          // var drawY=qYstart+(rowGapDigit)*(ans)-optWidth/2|0;
          // var drawX=qXstart+(optgapX+optWidth)*col|0;
          // drawOutline(canvas, drawX, drawY, optWidth);
        
        
      }
      filledOpt.push(ans);


    }
  return(filledOpt)
}

function getArqAns(canvas, qXstart, qYstart){

  var ansFind="no";
  var filledOpt=0;
  for(var opt=0; opt<5; opt++){
    var optAccurecy=0;
    var optX=qXstart+optWidth*opt+optgapX*opt-5;
    var optY=qYstart;
    var optImgData=canvas.getImageData(optX, optY, optLength, 1);
    var optPixArr=optImgData.data;
    
    var optAccurecyV=0;
    var optXV=optX+5+(optWidth/2|0);
    var optYV=optY-5-(optWidth/2|0);
    var optImgDataV=canvas.getImageData(optXV, optYV, 1, optLength);
    var optPixArrV=optImgDataV.data;
    for(var index=0; index<optLength; index++){
      if(optPixArr[index*4]<140){
        if(optPixArr[index*4+1]<140){
          if(optPixArr[index*4+1]<140){
            optAccurecy=optAccurecy+1;  
            if(optAccurecy>22){
              var tempAcc=0
              var newIndex =index-23;
              for(var tempInd=0; tempInd<23; tempInd++){
                if(optPixArr[index*4]<130){
                  if(optPixArr[index*4+1]<130){
                    if(optPixArr[index*4+1]<130){
                      tempAcc++;
                    }
                  }
                }
              }
              if(tempAcc>20){
                optAccurecy=25;
                break;
              }else{
                optAccurecy=tempAcc;
              }
            }
          }
        }
      }
    }
    drawLine(canvas, optX, optY, 10, 1);
    if(optAccurecy>maxAccurecy){
      if(ansFind=="no"){
        ansFind="yes";
        filledOpt=opt+1;

      }else{
        filledOpt="more";
        break;
      }
      
    }else {
      for(var index=0; index<optLength; index++){
        if(optPixArrV[index*4]<140){
          if(optPixArrV[index*4+1]<140){
            if(optPixArrV[index*4+1]<140){
              optAccurecyV=optAccurecyV+1;  
              if(optAccurecyV>22){
                var tempAcc=0
                var newIndex =index-23;
                for(var tempInd=0; tempInd<23; tempInd++){
                  if(optPixArrV[index*4]<130){
                    if(optPixArrV[index*4+1]<130){
                      if(optPixArrV[index*4+1]<130){
                        tempAcc++;
                      }
                    }
                  }
                }
                if(tempAcc>20){
                  optAccurecyV=25;
                  break;
                }else{
                  optAccurecyV=tempAcc;
                }
              }
            }
          }
        }
      }
    drawLine(canvas, optXV, optYV, 1, 10);

      if(optAccurecy<minAccurecy){
        if(optAccurecyV>maxAccurecyVnone){
          if(ansFind=="no"){
            ansFind="yes";
            filledOpt=opt+1;

          }else{
            filledOpt="more";
            break;
          }
        }else if(optAccurecyV<minAccurecyVnone){
          continue;
        }else{
          filledOpt="wrong";
          wrongRead++;
          ansFind="yes";
          break
        }
      }else{
        if(optAccurecyV>maxAccurecyVwrong){
          if(ansFind=="no"){
            ansFind="yes";
            filledOpt=opt+1;

          }else{
            filledOpt="more";
            break;
          }
        }else if(optAccurecyV<minAccurecyVwrong){
          continue;
        }else{
          filledOpt="wrong";
          wrongRead++;
          ansFind="yes";
          break
        }
        
      }
    }
  }
  if(ansFind=="no"){
    filledOpt="blank";
  }else if(ansFind=="yes"&&filledOpt!="wrong"&&filledOpt!="more"){
    // var drawX=(optWidth+optgapX)*(filledOpt-1)+qXstart;
    // var drawY=qYstart-(optHeight/2|0);
    // drawOutline(canvas, drawX, drawY, optWidth);
    
  }

  return(filledOpt);
}

function getTfqAns(canvas, qXstart, qYstart){
  var ansFind="no";
  var filledOpt=0;
  for(var opt=0; opt<4; opt++){
    var optAccurecy=0;
    var optX=qXstart+optWidth*opt+optgapX*opt-5;
    var optY=qYstart;
    var optImgData=canvas.getImageData(optX, optY, optLength, 1);
    var optPixArr=optImgData.data;
    
    var optAccurecyV=0;
    var optXV=optX+5+(optWidth/2|0);
    var optYV=optY-5-(optWidth/2|0);
    var optImgDataV=canvas.getImageData(optXV, optYV, 1, optLength);
    var optPixArrV=optImgDataV.data;
    for(var index=0; index<optLength; index++){
      if(optPixArr[index*4]<140){
        if(optPixArr[index*4+1]<140){
          if(optPixArr[index*4+1]<140){
            optAccurecy=optAccurecy+1;  
            if(optAccurecy>22){
              var tempAcc=0
              var newIndex =index-23;
              for(var tempInd=0; tempInd<23; tempInd++){
                if(optPixArr[index*4]<130){
                  if(optPixArr[index*4+1]<130){
                    if(optPixArr[index*4+1]<130){
                      tempAcc++;
                    }
                  }
                }
              }
              if(tempAcc>20){
                optAccurecy=25;
                break;
              }else{
                optAccurecy=tempAcc;
              }
            }
          }
        }
      }
    }
    drawLine(canvas, optX, optY, 10, 1);
    if(optAccurecy>maxAccurecy){
      if(ansFind=="no"){
        ansFind="yes";
        filledOpt=opt+1;

      }else{
        filledOpt="more";
        break;
      }
      
    }else {
      for(var index=0; index<optLength; index++){
        if(optPixArrV[index*4]<140){
          if(optPixArrV[index*4+1]<140){
            if(optPixArrV[index*4+1]<140){
              optAccurecyV=optAccurecyV+1;  
              if(optAccurecyV>22){
                var tempAcc=0
                var newIndex =index-23;
                for(var tempInd=0; tempInd<23; tempInd++){
                  if(optPixArrV[index*4]<130){
                    if(optPixArrV[index*4+1]<130){
                      if(optPixArrV[index*4+1]<130){
                        tempAcc++;
                      }
                    }
                  }
                }
                if(tempAcc>20){
                  optAccurecyV=25;
                  break;
                }else{
                  optAccurecyV=tempAcc;
                }
              }
            }
          }
        }
      }
    drawLine(canvas, optXV, optYV, 1, 10);

      if(optAccurecy<minAccurecy){
        if(optAccurecyV>maxAccurecyVnone){
          if(ansFind=="no"){
            ansFind="yes";
            filledOpt=opt+1;

          }else{
            filledOpt="more";
            break;
          }
        }else if(optAccurecyV<minAccurecyVnone){
          continue;
        }else{
          filledOpt="wrong";
          wrongRead++;
          ansFind="yes";
          break
        }
      }else{
        if(optAccurecyV>maxAccurecyVwrong){
          if(ansFind=="no"){
            ansFind="yes";
            filledOpt=opt+1;

          }else{
            filledOpt="more";
            break;
          }
        }else if(optAccurecyV<minAccurecyVwrong){
          continue;
        }else{
          filledOpt="wrong";
          wrongRead++;
          ansFind="yes";
          break
        }
        
      }
    }
    
    
    
  }
  if(ansFind=="no"){
    filledOpt="blank";
  }else if(ansFind=="yes"&&filledOpt!="wrong"&&filledOpt!="more"){
    // var drawX=(optWidth+optgapX)*(filledOpt-1)+qXstart;
    // var drawY=qYstart-(optHeight/2|0);
    // drawOutline(canvas, drawX, drawY, optWidth);
    
  }

  return(filledOpt);
}

function getQY(subNo, barNo){
  switch(subNo){
    case 0:
      var qY=barsY['left'][barNo];
      break;
    case 1:
      var qY=(barsY['left'][barNo]+barsY['right'][barNo])/2|0;
      break;
    case 2:
      var qY=barsY['right'][barNo];
      break;
  }
  return qY;
}

function getResult(canvas){
    var stdSolData={};
    for(var subNo=0; subNo<3; subNo++){
        var subName="sub_"+(subNo+1);
        switch(subNo){
          case 0:
            xIdGap=0;
            break;
          case 1:
            xIdGap=7;

            break;
          case 2:
            xIdGap=14;

            break;
        }
        stdSolData[subName]={};
        if(mcqsQs>0){
            stdSolData[subName]['mcqsq']=new Array();
            mcqsSol=new Array();
            for(var n=0; n<mcqsQs; n++){
              if(n<mcqsQsCa){
                var clmNo=0;
                var qNoInClm=n;
                var xId=2+xIdGap;
              }else{
                var clmNo=1;
                var qNoInClm=n-mcqsQsCa;
                var xId=5+xIdGap;
              }
              var barNo=qNoInClm;
              
              var qXstart=xes[xId]+barsX[barNo]-15;
              var qYstart=getQY(subNo, barNo);
              var thisAnsSol=getMcqsAns(canvas, qXstart, qYstart);

              mcqsSol.push(thisAnsSol);
            }
            

            stdSolData[subName]['mcqsq']=mcqsSol;
        }
        
        if(mcqmQs>0){
            stdSolData[subName]['mcqmq']=new Array();
            mcqmSol=new Array();
            for(var n=0; n<mcqmQs; n++){
              if(n<mcqmQsCa){
                var clmNo=0;
                var qNoInClm=n;
                var xId=2+xIdGap;
              }else{
                var clmNo=1;
                var qNoInClm=n-mcqmQsCa;
                var xId=5+xIdGap;
              }
              var barNo=mcqsQsCa+qNoInClm;
              var qXstart=barsX[barNo]+xes[xId]-15;
              var qYstart=getQY(subNo, barNo);
              var thisAnsSol=getMcqmAns(canvas, qXstart, qYstart);

              mcqmSol.push(thisAnsSol);
            }
            stdSolData[subName]['mcqmq']=mcqmSol;
        }

        if(compQs>0){
            stdSolData[subName]['compq']=new Array();
            compqSol=new Array();
            stdSolData[subName]['compq']=new Array();
            compqSol=new Array();
            for(var n=0; n<compQs; n++){
              if(n<compQsCa){
                var clmNo=0;
                var qNoInClm=n;
                var xId=2+xIdGap;
              }else{
                var clmNo=1;
                var qNoInClm=n-compQsCa;
                var xId=5+xIdGap;
              }
              var barNo=mcqsQsCa+mcqmQsCa+qNoInClm;
              var qXstart=barsX[barNo]+xes[xId]-15;
              var qYstart=getQY(subNo, barNo);
              var thisAnsSol=getCompqAns(canvas, qXstart, qYstart);

              compqSol.push(thisAnsSol);
            }
            stdSolData[subName]['compq']=compqSol;
        }

        if(digit1Qs>0){
          stdSolData[subName]['digit1q']=new Array();
          digit1Sol=new Array();
                      
          for(var n=0; n<digit1Qs; n++){

            ///////////////horizontal qs marking...../////////////////////
              var barNo=mcqsQsCa+mcqmQsCa+compQsCa+0;
              var xId=1+xIdGap;
              var qXstart=barsX[barNo]+xes[xId]+n*58;
              var qYstart=getQY(subNo, barNo);
              var thisAnsSol=get1digitqAns(canvas, qXstart, qYstart);
              digit1Sol.push(thisAnsSol);
              
          }
          stdSolData[subName]['digit1q']=digit1Sol;

        }

        if(matrixQs>0){
          stdSolData[subName]['matrixq']=new Array();
          matrixSol=new Array();
          for(var n=0; n<matrixQs; n++){
            if(n<matrixQsCa){
                var clmNo=0;
                var qNoInClm=n;
                var xId=1+xIdGap;
              }else{
                var clmNo=1;
                var qNoInClm=n-matrixQsCa;
                var xId=4+xIdGap;
              }
              var barNo=mcqsQsCa+mcqmQsCa+compQsCa+1+qNoInClm;
              var qXstart=barsX[barNo]+xes[xId];
              var qYstart=getQY(subNo, barNo);
              var thisAnsSol=getMatrixqAns(canvas, qXstart, qYstart);
                
               matrixSol.push(thisAnsSol);
            }
            stdSolData[subName]['matrixq']=matrixSol;
        }

        if(digitQs>0){
          stdSolData[subName]['digitq']=new Array();
          digitSol=new Array();
          if(digitQs%3==1){
            var digitQsCa=parseInt(digitQs/3)+1;
            var digitQsCb=parseInt(digitQs/3);
            var digitQsCc=parseInt(digitQs/3);
          }else if(digitQs%3==2){
            var digitQsCa=parseInt(digitQs/3)+1;
            var digitQsCb=parseInt(digitQs/3)+1;
            var digitQsCc=parseInt(digitQs/3);
          }else{
            var digitQsCa=parseInt(digitQs/3);
            var digitQsCb=parseInt(digitQs/3);
            var digitQsCc=parseInt(digitQs/3);
          
          }
            
          for(var n=0; n<digitQsCa; n++){

            ///////////////horizontal qs marking...../////////////////////
              var barNo=mcqsQsCa+mcqmQsCa+compQsCa+1+matrixQsCa+n;
              var xId=0+xIdGap;
              var qXstarta=barsX[barNo]+xes[xId];
              var qYstarta=getQY(subNo, barNo);
              var thisAnsSol=get4digitqAns(canvas, qXstarta, qYstarta);
              digitSol.push(thisAnsSol);
              if(n<digitQsCb){
                var xId=3+xIdGap;
                var qXstartb=barsX[barNo]+xes[xId];
                var qYstartb=getQY(subNo, barNo);
                var thisAnsSol=get4digitqAns(canvas, qXstartb, qYstartb);
                digitSol.push(thisAnsSol);
              }
              if(n<digitQsCc){
                var xId=6+xIdGap;
                var qXstartc=barsX[barNo]+xes[xId];
                var qYstartc=getQY(subNo, barNo);
                var thisAnsSol=get4digitqAns(canvas, qXstartc, qYstartc);
                digitSol.push(thisAnsSol);
              }
          }
          stdSolData[subName]['digitq']=digitSol;

        }

        if(arQs>0){
              stdSolData[subName]['arq']=new Array();
              arqSol=new Array();
              for(var n=0; n<arQs; n++){
                if(n<arQsCa){
                  var clmNo=0;
                  var qNoInClm=n;
                  var xId=2+xIdGap;
                }else{
                  var clmNo=1;
                  var qNoInClm=n-arQsCa;
                  var xId=5+xIdGap;
                }

                var barNo=mcqsQsCa+mcqmQsCa+compQsCa+1+matrixQsCa+0+qNoInClm;
                var qXstart=xes[xId]+barsX[barNo]-15;
                var qYstart=getQY(subNo, barNo);
                var thisAnsSol=getArqAns(canvas, qXstart, qYstart);

                arqSol.push(thisAnsSol);
              }
              

              stdSolData[subName]['arq']=arqSol;
        }

        if(tfQs>0){
            stdSolData[subName]['tfq']=new Array();
            tfqSol=new Array();
            for(var n=0; n<tfQs; n++){
              if(n<tfQsCa){
                var clmNo=0;
                var qNoInClm=n;
                var xId=2+xIdGap;
              }else{
                var clmNo=1;
                var qNoInClm=n-tfQsCa;
                var xId=5+xIdGap;
              }
              var barNo=mcqsQsCa+mcqmQsCa+compQsCa+1+matrixQsCa+0+tfQsCa+qNoInClm;
              
              var qXstart=xes[xId]+barsX[barNo]-15;
              var qYstart=getQY(subNo, barNo);
              var thisAnsSol=getTfqAns(canvas, qXstart, qYstart);

              tfqSol.push(thisAnsSol);
            }
            

            stdSolData[subName]['tfq']=tfqSol;
        }
  
    }
    return(stdSolData);
}

function drawOutline(canvas, x, y, l){
  var imgData1=canvas.getImageData(x, y, l, 1);
  var imgData2=canvas.getImageData(x+l, y, 1, l);
  var imgData3=canvas.getImageData(x, y+l, l, 1);
  var imgData4=canvas.getImageData(x, y, 1, l);

  var imgarr1=imgData1.data;
  var imgarr2=imgData2.data;
  var imgarr3=imgData3.data;
  var imgarr4=imgData4.data;

  for(var i=0; i<l; i++){
    imgarr1[i*4]=255;
    imgarr1[i*4+1]=0;
    imgarr1[i*4+2]=0;
    imgarr2[i*4]=255;
    imgarr2[i*4+1]=0;
    imgarr2[i*4+2]=0;
    imgarr3[i*4]=255;
    imgarr3[i*4+1]=0;
    imgarr3[i*4+2]=0;
    imgarr4[i*4]=255;
    imgarr4[i*4+1]=0;
    imgarr4[i*4+2]=0;

  }
  canvas.putImageData(imgData1, x, y);
  canvas.putImageData(imgData2, x+l, y);
  canvas.putImageData(imgData3, x, y+l);
  canvas.putImageData(imgData4, x, y);
} 

function drawLine(canvas, x, y, l, h){
  if(l<1){
    l=1;
  }
  if(h<1){
    h=1;
  }
  var imgData1=canvas.getImageData(x, y, l, h);

  var imgarr1=imgData1.data;

  for(var i=0; i<l*h; i++){
    imgarr1[i*4]=255;
    imgarr1[i*4+1]=0;
    imgarr1[i*4+2]=0;

  }
  canvas.putImageData(imgData1, x, y);
} 

function getRollNo(canvas){
  
  rollNo=new Array();
  var rollNoString="";
  for(var position=0; position<10; position++){
    var squareGap=cX2-cX;
    rollNoX=(squareGap/2183)*388|0;
    if(mcqsQs>0){
      rollNoY=(barsY['left'][0]-cY)/5.6|0;
    }
    var rollNoXX=rollNoX+position*(optWidth+optgapX);
    var newData=newPosition(rotationAngle, rotation, rollNoXX, rollNoY);
    digitX=newData.x;
    digitY=newData.y;
    digiX=digitX+cX;
    digitY=digitY+cY;
    second_loop:
    
    for(var digit=0; digit<10; digit++){
      var digitAccurecy=0;
      var digiY=digitY+(rollDigitGapY)*digit;
      
      var digitPixData=canvas.getImageData((digiX-7), digiY, optLength, 1);
      var digitPixArr=digitPixData.data;
      for(var _index=0; _index<optLength; _index++){
        if(digitPixArr[_index*4]<130){
          if(digitPixArr[_index*4+1]<130){
            if(digitPixArr[_index*4+2]<130){
              digitAccurecy=digitAccurecy+1;

            }
          }
        }
      }
      if(digitAccurecy>19){
        rollNoString=rollNoString+digit+"";
        break;
      }
    drawOutline(canvas, digiX, digiY, 22);

    }

  }

  return(rollNoString);
}
