<?php
require_once('webpanelcw/config/mpj_db.php');
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}


if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
  if ($lang == "en") {
    $stmt = $conn->prepare("SELECT * FROM work_content_en");
    $stmt->execute();
    $row_work_content = $stmt->fetch(PDO::FETCH_ASSOC);
  } else {
    $stmt = $conn->prepare("SELECT * FROM work_content");
    $stmt->execute();
    $row_work_content = $stmt->fetch(PDO::FETCH_ASSOC);
  }
} else {
  $stmt = $conn->prepare("SELECT * FROM work_content");
  $stmt->execute();
  $row_work_content = $stmt->fetch(PDO::FETCH_ASSOC);
}



if (isset($_GET['lang'])) {
  $lang = $_GET['lang'];
  if ($lang == "en") {
    $stmt = $conn->prepare("SELECT * FROM position_en");
    $stmt->execute();
    $row_position = $stmt->fetchAll();
  } else {
    $stmt = $conn->prepare("SELECT * FROM position");
    $stmt->execute();
    $row_position = $stmt->fetchAll();
  }
} else {
  $stmt = $conn->prepare("SELECT * FROM position");
  $stmt->execute();
  $row_position = $stmt->fetchAll();
}

$secret = "6LcqsUEkAAAAAL-SQkVRts-_xijM3Ii6nbA6GBh_";


if (isset($_POST['g-recaptcha-response'])) {

  $captcha = $_POST['g-recaptcha-response'];
  $veifyResponse = file_get_contents('https://google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $captcha);
  $responseData = json_decode($veifyResponse);

  if (!$captcha) {

    echo "<script>alert('คุณไม่ได้ป้อน reCAPTCHA อย่างถูกต้อง')</script>";
  }
}




?>



<!DOCTYPE html>
<html lang="en" class="desktop">

<head>

  <link rel="shortcut icon" href="images/favicon.ico">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=0.85">
  <meta name="description" content="mpj-logistics">
  <meta name="keyword" content="mpj-logistics">
  <meta name="author" content="mpj-logistics">
  <link rel="shortcut icon" href="images/logo.svg" type="image/png">
  <title>mpj-logistics</title>




  <link href="css/spinner.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">


  <script src="js/core.min.js"></script>
  <script src="js/script.min.js"></script>

  <script src="js/jquery.min.js"></script>

  <script type="text/javascript">
    'use strict';
    var $window = $(window);
    $window.on({
      'load': function() {

        /* Preloader */
        $('.spinner').fadeOut(2500);
      },

    });
  </script>


</head>

<body>
  <!-- Pre loader -->
  <div class="spinner" id="loading-body">
    <div>
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div>
  </div>

  <?php include("header.php"); ?>

  <main>


    <img class="img-fluid w-100" src="upload/bg01.jpg">


    <?php include("navigator.php"); ?>


    <section id="page-section">
      <div class="container-xxl">





        <div class="text-center mb-5">
          <h3 class="text-warning"><?php if (isset($_GET['lang'])) {
                                      if ($_GET['lang'] == "en") {
                                        echo 'work with us';
                                      } else {
                                        echo 'ร่วมงานกับเรา';
                                      }
                                    } else {
                                      echo "ร่วมงานกับเรา";
                                    } ?></h3>
        </div>







        <h4 class="text-dark"><?php echo $row_work_content['content']; ?></h4>



        <h4 class="text-dark mt-5"><?php if (isset($_GET['lang'])) {
                                      if ($_GET['lang'] == "en") {
                                        echo 'View open positions';
                                      } else {
                                        echo 'ดูตำแหน่งที่เปิดรับ';
                                      }
                                    } else {
                                      echo "ดูตำแหน่งที่เปิดรับ";
                                    } ?></h4>







        <?php for ($j = 0; $j < count($row_position); $j++) { ?>
          <div class="qa-box">
            <a href="javascript:;" class="qa-title"><?php echo $row_position[$j]['position_name']; ?>
              <div class="box-icon">

                <span></span>
                <span></span>
              </div>
            </a>

            <div class="qa-content" style="display: none;">

              <?php
              if (isset($_GET['lang'])) {
                $lang = $_GET['lang'];
                if ($lang == "en") {
                  $stmt = $conn->prepare("SELECT * FROM detail_pos_en WHERE id = :id");
                  $stmt->bindParam(":id", $row_position[$j]['id']);
                  $stmt->execute();
                  $row_detail_pos = $stmt->fetchAll();
                } else {
                  $stmt = $conn->prepare("SELECT * FROM detail_pos WHERE id = :id");
                  $stmt->bindParam(":id", $row_position[$j]['id']);
                  $stmt->execute();
                  $row_detail_pos = $stmt->fetchAll();
                }
              } else {
                $stmt = $conn->prepare("SELECT * FROM detail_pos WHERE id = :id");
                $stmt->bindParam(":id", $row_position[$j]['id']);
                $stmt->execute();
                $row_detail_pos = $stmt->fetchAll();
              }

              for ($i = 0; $i < count($row_detail_pos); $i++) { ?>
                <p class="text-dark"><?php echo $row_detail_pos[$i]['content']; ?></p>
              <?php } ?>
            </div>

          <?php } ?>
          </div>






          <div class="text-center my-5">
            <h3 class="text-warning"><?php if (isset($_GET['lang'])) {
                                        if ($_GET['lang'] == "en") {
                                          echo 'Interested in applying for a job';
                                        } else {
                                          echo 'สนใจสมัครงาน';
                                        }
                                      } else {
                                        echo "สนใจสมัครงาน";
                                      } ?></h3>
          </div>

          <div class="text-center">
            <p><?php if (isset($_GET['lang'])) {
                  if ($_GET['lang'] == "en") {
                    echo 'Fill in the information below and attach a job application form.';
                  } else {
                    echo 'กรอกข้อมูลด้านล่างพร้อมแนบแบบฟอร์มสมัครงาน';
                  }
                } else {
                  echo "กรอกข้อมูลด้านล่างพร้อมแนบแบบฟอร์มสมัครงาน";
                } ?></p>

            <a href="upload/pdf.pdf" class="btn btn-warning rounded-0" target="_blank"><span class="material-icons-sharp">vertical_align_bottom</span> <?php if (isset($_GET['lang'])) {
                                                                                                                                                          if ($_GET['lang'] == "en") {
                                                                                                                                                            echo 'Download the job application form here.';
                                                                                                                                                          } else {
                                                                                                                                                            echo 'ดาวน์โหลดแบบฟอร์มสมัครงานที่นี่';
                                                                                                                                                          }
                                                                                                                                                        } else {
                                                                                                                                                          echo "ดาวน์โหลดแบบฟอร์มสมัครงานที่นี่";
                                                                                                                                                        } ?></a>
          </div>

          <form method="POST" action="sendmail.php" enctype="multipart/form-data">
            <div class="row mt-5">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputName"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Name - Surname';
                                            } else {
                                              echo 'ชื่อ - นามสกุล';
                                            }
                                          } else {
                                            echo "ชื่อ - นามสกุล";
                                          } ?> <span class="text-danger">*</span></label>
                  <input name="fullname" type="text" class="form-control rounded-0" id="inputName" placeholder="">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputName"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Age';
                                            } else {
                                              echo 'อายุ';
                                            }
                                          } else {
                                            echo "อายุ";
                                          } ?> <span class="text-danger">*</span></label>
                  <input name="age" type="text" class="form-control rounded-0" id="inputName" placeholder="">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputEmail"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Tel';
                                            } else {
                                              echo 'เบอร์โทรศัพท์';
                                            }
                                          } else {
                                            echo "เบอร์โทรศัพท์";
                                          } ?> <span class="text-danger">*</span></label>
                  <input name="phone" type="tel" class="form-control rounded-0" id="inputEmail" placeholder="">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputEmail"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Email';
                                            } else {
                                              echo 'อีเมล';
                                            }
                                          } else {
                                            echo "อีเมล";
                                          } ?> <span class="text-danger">*</span></label>
                  <input name="email" type="email" class="form-control rounded-0" id="inputEmail" placeholder="">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputEmail"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Job position you wish to apply for';
                                            } else {
                                              echo 'ตำแหน่งงานที่ต้องการสมัคร';
                                            }
                                          } else {
                                            echo "ตำแหน่งงานที่ต้องการสมัคร";
                                          } ?> <span class="text-danger">*</span></label>
                  <input name="position" type="text" class="form-control rounded-0" id="inputEmail" placeholder="">
                </div>
              </div>


              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputEmail"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Desired salary';
                                            } else {
                                              echo 'เงินเดือนที่ต้องการ';
                                            }
                                          } else {
                                            echo "เงินเดือนที่ต้องการ";
                                          } ?> <span class="text-danger">*</span></label>
                  <input name="money" type="text" class="form-control rounded-0" id="inputEmail" placeholder="">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputEmail"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Working Experience (Years)';
                                            } else {
                                              echo 'ประสบการณ์ในการทำงาน (ปี)';
                                            }
                                          } else {
                                            echo "ประสบการณ์ในการทำงาน (ปี)";
                                          } ?></label>
                  <select name="exp" class="form-select rounded-0" aria-label="Default select example">
                    <option value=""></option>
                    <option value="ไม่มีประสบการณ์" data-calc-value="ไม่มีประสบการณ์">
                      <?php if (isset($_GET['lang'])) {
                        if ($_GET['lang'] == "en") {
                          echo 'Inexperienced';
                        } else {
                          echo 'ไม่มีประสบการณ์';
                        }
                      } else {
                        echo "ไม่มีประสบการณ์";
                      } ?>
                    </option>
                    <option value="1-2 ปี" data-calc-value="1-2 ปี">
                      <?php if (isset($_GET['lang'])) {
                        if ($_GET['lang'] == "en") {
                          echo '1-2 years';
                        } else {
                          echo '1-2 ปี';
                        }
                      } else {
                        echo "1-2 ปี";
                      } ?>
                    </option>
                    <option value="2-3 ปี" data-calc-value="2-3 ปี">
                      <?php if (isset($_GET['lang'])) {
                        if ($_GET['lang'] == "en") {
                          echo '2-3 years';
                        } else {
                          echo '2-3 ปี';
                        }
                      } else {
                        echo "2-3 ปี";
                      } ?>
                    </option>
                    <option value="3-4 ปี" data-calc-value="3-4 ปี">
                      <?php if (isset($_GET['lang'])) {
                        if ($_GET['lang'] == "en") {
                          echo '3-4 years';
                        } else {
                          echo '3-4 ปี';
                        }
                      } else {
                        echo "3-4 ปี";
                      } ?>
                    </option>
                    <option value="4-5 ปี" data-calc-value="4-5 ปี">
                      <?php if (isset($_GET['lang'])) {
                        if ($_GET['lang'] == "en") {
                          echo '4-5 years';
                        } else {
                          echo '4-5 ปี';
                        }
                      } else {
                        echo "4-5 ปี";
                      } ?>
                    </option>
                    <option value="มากกว่า 5 ปี" data-calc-value="มากกว่า 5 ปี">
                      <?php if (isset($_GET['lang'])) {
                        if ($_GET['lang'] == "en") {
                          echo 'More than 5 years';
                        } else {
                          echo 'มากกว่า 5 ปี';
                        }
                      } else {
                        echo "มากกว่า 5 ปี";
                      } ?>
                    </option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="formFile"><?php if (isset($_GET['lang'])) {
                                          if ($_GET['lang'] == "en") {
                                            echo 'Attach application form';
                                          } else {
                                            echo 'แนบแบบฟอร์มสมัครงาน';
                                          }
                                        } else {
                                          echo "แนบแบบฟอร์มสมัครงาน";
                                        } ?> <span class="text-danger">*</span></label>
                  <input name="pdf" class="form-control rounded-0" type="file" id="formFile">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group mb-3">
                  <label for="inputName"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Ask for more information';
                                            } else {
                                              echo 'สอบถามเพิ่มเติม';
                                            }
                                          } else {
                                            echo "สอบถามเพิ่มเติม";
                                          } ?></label>
                  <textarea name="message" class="form-control rounded-0" rows="8" placeholder="<?php if (isset($_GET['lang'])) {
                                                                                                  if ($_GET['lang'] == "en") {
                                                                                                    echo 'Write your message here.';
                                                                                                  } else {
                                                                                                    echo 'เขียนข้อความของคุณที่นี่';
                                                                                                  }
                                                                                                } else {
                                                                                                  echo "เขียนข้อความของคุณที่นี่";
                                                                                                } ?>" id="textareaMessage"></textarea>
                </div>

              </div>
              <div class="col-md-12 text-center">

                <div class="g-recaptcha" data-sitekey="6LcqsUEkAAAAANlj03__XSnP0LfPDHL_056Boo0Y" style="display: flex;justify-content: center;"></div>

                <br> 
                <button type="submit" name='sentmail' class="btn btn btn-dark btn-lg rounded-0 px-lg-5"><?php if (isset($_GET['lang'])) {
                                                                                                          if ($_GET['lang'] == "en") {
                                                                                                            echo 'Apply for work';
                                                                                                          } else {
                                                                                                            echo 'สมัครงาน';
                                                                                                          }
                                                                                                        } else {
                                                                                                          echo "สมัครงาน";
                                                                                                        } ?></button>
              </div>



            </div>
          </form>






          <div class="text-center my-5">
            <h3 class="text-warning"><?php if (isset($_GET['lang'])) {
                                        if ($_GET['lang'] == "en") {
                                          echo 'Report a complaint';
                                        } else {
                                          echo 'แจ้งเรื่องร้องเรียน';
                                        }
                                      } else {
                                        echo "แจ้งเรื่องร้องเรียน";
                                      } ?></h3>
          </div>


          <form method="POST" action="sendmail06.php">
            <div class="row mt-5">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputName"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Title';
                                            } else {
                                              echo 'ชื่อเรื่อง';
                                            }
                                          } else {
                                            echo "ชื่อเรื่อง";
                                          } ?></label>
                  <input name="title" type="text" class="form-control rounded-0" id="inputName" placeholder="<?php if (isset($_GET['lang'])) {
                                                                                                                if ($_GET['lang'] == "en") {
                                                                                                                  echo 'Fill in title';
                                                                                                                } else {
                                                                                                                  echo 'กรอกชื่อเรื่อง';
                                                                                                                }
                                                                                                              } else {
                                                                                                                echo "กรอกชื่อเรื่อง";
                                                                                                              } ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputName"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Name';
                                            } else {
                                              echo 'ชื่อ';
                                            }
                                          } else {
                                            echo "ชื่อ";
                                          } ?></label>
                  <input name="fullname" type="text" class="form-control rounded-0" id="inputName" placeholder="<?php if (isset($_GET['lang'])) {
                                                                                                                  if ($_GET['lang'] == "en") {
                                                                                                                    echo 'Fill in name';
                                                                                                                  } else {
                                                                                                                    echo 'กรอกชื่อ';
                                                                                                                  }
                                                                                                                } else {
                                                                                                                  echo "กรอกชื่อ";
                                                                                                                } ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputEmail"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Email';
                                            } else {
                                              echo 'อีเมล';
                                            }
                                          } else {
                                            echo "อีเมล";
                                          } ?></label>
                  <input name="email" type="email" class="form-control rounded-0" id="inputEmail" placeholder="<?php if (isset($_GET['lang'])) {
                                                                                                                  if ($_GET['lang'] == "en") {
                                                                                                                    echo 'Enter email';
                                                                                                                  } else {
                                                                                                                    echo 'กรอกอีเมล';
                                                                                                                  }
                                                                                                                } else {
                                                                                                                  echo "กรอกอีเมล";
                                                                                                                } ?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label for="inputEmail"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Tel';
                                            } else {
                                              echo 'โทรศัพท์';
                                            }
                                          } else {
                                            echo "โทรศัพท์";
                                          } ?></label>
                  <input name="phone" type="tel" class="form-control rounded-0" id="inputEmail" placeholder="<?php if (isset($_GET['lang'])) {
                                                                                                                  if ($_GET['lang'] == "en") {
                                                                                                                    echo 'Fill in the phone';
                                                                                                                  } else {
                                                                                                                    echo 'กรอกโทรศัพท์';
                                                                                                                  }
                                                                                                                } else {
                                                                                                                  echo "กรอกโทรศัพท์";
                                                                                                                } ?>">
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group mb-3">
                  <label for="inputName"><?php if (isset($_GET['lang'])) {
                                            if ($_GET['lang'] == "en") {
                                              echo 'Message';
                                            } else {
                                              echo 'ข้อความ';
                                            }
                                          } else {
                                            echo "ข้อความ";
                                          } ?></label>
                  <textarea name="message" class="form-control rounded-0" rows="8" placeholder="<?php if (isset($_GET['lang'])) {
                                                                                                  if ($_GET['lang'] == "en") {
                                                                                                    echo 'Write your message here.';
                                                                                                  } else {
                                                                                                    echo 'เขียนข้อความของคุณที่นี่';
                                                                                                  }
                                                                                                } else {
                                                                                                  echo "เขียนข้อความของคุณที่นี่";
                                                                                                } ?>" id="textareaMessage"></textarea>
                </div>

              </div>
              <div class="col-md-12 text-center">



                <div class="g-recaptcha" data-sitekey="6LcqsUEkAAAAANlj03__XSnP0LfPDHL_056Boo0Y" style="display: flex;justify-content: center;"></div>


                <div class="clearfix mt-3"></div>

               <button type="submit" name='sentmail6' class="btn btn btn-dark btn-lg rounded-0 px-lg-5"><i class="icofont-send-mail"></i> <?php if (isset($_GET['lang'])) {
                                                                                                                                              if ($_GET['lang'] == "en") {
                                                                                                                                                echo 'Send a message';
                                                                                                                                              } else {
                                                                                                                                                echo 'ส่งข้อความ';
                                                                                                                                              }
                                                                                                                                            } else {
                                                                                                                                              echo "ส่งข้อความ";
                                                                                                                                            } ?></button>
                <a href="" class="btn btn btn-dark btn-lg rounded-0 px-lg-5"><i class="icofont-refresh"></i> <?php if (isset($_GET['lang'])) {
                                                                                                                if ($_GET['lang'] == "en") {
                                                                                                                  echo 'Cleanup';
                                                                                                                } else {
                                                                                                                  echo 'ล้างข้อมูล';
                                                                                                                }
                                                                                                              } else {
                                                                                                                echo "ล้างข้อมูล";
                                                                                                              } ?></a>
              </div>
            </div>
          </form>

      </div>

    </section>



  </main>


  <?php include("footer.php"); ?>

  <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</body>

</html>