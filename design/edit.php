<?php



// 友達の名前を取得し表示
    $dsn = 'mysql:dbname=myfriends;host=localhost';
     $user = 'root';
     $password = 'mysql';
     $dbh = new PDO($dsn, $user, $password);
     $dbh->query('SET NAMES utf8');

     // SQL作成
     $sql = 'SELECT * FROM `areas` ';

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    
    



 //データの取得(友達情報)
    $areas = array();

  
  while (1) {
    // データの取得
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    // データが取得できなくなったら繰り返しの処理を終了
    if ($rec == false){
      break;
     }


    $areas[] = $rec;
  }


     // パラメータを受け取る
     $friend_id = $_GET['friend_id'];

    //sql文を作成 
     $sql = 'SELECT * FROM `friends` WHERE `friend_id`='.$friend_id;

     // ｓｑｌを実行
    $stmt = $dbh->prepare($sql);
     $stmt->execute();

     // 友達のデータ取得
     $friends = $stmt->fetch(PDO::FETCH_ASSOC);

     //データの更新処理
     if (isset($_POST) && !empty($_POST)){
      
      $sql = 'UPDATE `friends` SET `friend_name`="'.$_POST['name'].'",`area_id`='.$_POST['area_id'].',`gender`='.$_POST['gender'].',`age`='.$_POST['age'].' WHERE `friend_id` = '.$friend_id;
  
    // SQLを実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
  
    //更新処理完了後、index.phpへ遷移
    header('Location: index.php');
   }
 
   // DB切断
   $dbh = null;
  

  

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>myFriends</title>

    <!-- Bootstrap -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/timeline.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>f
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><span class="strong-title"><i class="fa fa-facebook-square"></i> My friends</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
        <legend>友達の編集</legend>
        <form method="post" action="" class="form-horizontal" role="form">
            <!-- 名前 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">名前</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="山田　太郎" value="<?php echo $friends['friend_name']; ?>">
              </div>
            </div>
            <!-- 出身 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">出身</label>
              <div class="col-sm-10">
                <select class="form-control" name="area_id">
                  <option value="0">出身地を選択</option>
                  <?php foreach ($areas as $area):?>
                    <?php if ($area['area_id']== $friends['area_id']){ ?>
                      <option value="<?php echo $area['area_id'];?>" selected><?php echo $area['area_name']; ?></option>
                      <?php }else{ ?>
                      <option value="<?php echo $area[$area_id];?>" ><?php echo $area['area_name']; ?></option>
                      <?php }?>
                      <?php endforeach; ?>
                  <!-- <option value="1" selected>北海道</option>
                  <option value="2">青森</option>
                  <option value="3">岩手</option>
                  <option value="4">宮城</option>
                  <option value="5">秋田</option> -->
                </select>
              </div>
            </div>
            <!-- 性別 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">性別</label>
              <div class="col-sm-10">
                <select class="form-control" name="gender">
                  <option value="0">性別を選択</option>
                  <?php if ($friends['gender'] == 0) { ?>
                  <option value="0" selected>男性</option>
                  <option value="1" >女性</option>
                  <?php } elseif ($friends['gender'] == 0) {?>
                  <option value="0">男性</option>
                  <option value="1" selected>女性</option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <!-- 年齢 -->
            <div class="form-group">
              <label class="col-sm-2 control-label">年齢</label>
              <div class="col-sm-10">
                <input type="text" name="age" class="form-control" placeholder="例：27" value="<?php echo $friends['age']?>">
              </div>
            </div>

          <input type="submit" class="btn btn-default" value="更新">
        </form>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
