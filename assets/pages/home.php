
<?php 

require(getcwd().'/assets/php/database.php');

?>

<?php

$user=$_SESSION['userdata'];
$balance = $user['balance']=getCreditedBalance($user['id'])- getDebitedBalance($user['id']);
$history = $user['trans_history']=getTransHistory($user['id']);

$id = $user['id'];
$sql = "SELECT * FROM trans WHERE to_user_id = $id";
$result = mysqli_query($db,$sql);
$wallet = mysqli_fetch_assoc($result);
$_SESSION['id']= $id;
$balance = $wallet['amount'];
$_SESSION['amount'] = $balance;
// $_SESSION['amount']= $wa['amount'];

?>

<?php 

if(isset($_POST['d'])){
echo $user['full_name'];
    // $user=$_SESSION['userdata'];
    // $id = $user['id'];
    
  
        $depostionAmount = $_POST['depositeno']+$balance;
        $sql = "UPDATE trans SET amount =$depostionAmount WHERE  to_user_id = $id";
        if(!mysqli_query($db,$sql)){
            echo "Depostion Failed: ".mysqli_error();
        }
        echo "<script>window.location = 'index.php'</script>";
    }


    if(isset($_POST['w'])){
        if($_POST['withdrawno'] > $balance){
          
            echo "  <script>
        $(`<div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">
            <div>
                Invalid : Not Enough Balance
            </div>
        </div>`).insertBefore('.modal input');
        </script>";
        }
        else{
          $user=$_SESSION['userdata'];
          $id = $user['id'];
            $withdrawno = $balance - $_POST['withdrawno'];
            $sql = "UPDATE trans SET amount =$withdrawno WHERE to_user_id = $id";
            if(!mysqli_query($db,$sql)){
                echo "withdraw Failed: ".mysqli_error();
            }
        }
        echo "<script>window.location = 'index.php'</script>";
    }

    
        // $sql = "SELECT * FROM trans WHERE from_user_id = $id";
        // $result = mysqli_query($db,$sql);
        // $wallet = mysqli_fetch_assoc($result);
        // $balance = $wallet['amount'];

  
?>
<div class="container">

<div id="menu_bar" class="d-flex justify-content-between col-7 m-auto mt-3">
<button type="button" class="btn btn-primary">
  Wallet <span class="badge bg-secondary"><?=$balance?> Rs</span>
</button>

<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="submit" name= "sendmoney">
Send Money
</button>

<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Deposit" type="submit" name="deposit">
Deposit
</button>


<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#withdraw" type="submit" name="withdraw">
Withdraw
</button>


<a href="assets/pages/shop.php" class="btn btn-danger">
  shopping
</a> 

</div>

<div id="trans_list">
<?php
foreach($history as $trans){
  $suffix="";
    if($trans['from_user_id']==$user['id']){
        $color="danger";
$suffix= "to ".getUserById($trans['to_user_id'])['full_name']." (".getUserById($trans['to_user_id'])['mobile'].") " ;
    }else{
        $color="success";

$suffix= "from ".getUserById($trans['from_user_id'])['full_name']." (".getUserById($trans['from_user_id'])['mobile'].") " ;

    }
    ?>
<div class="card col-7 shadow rounded m-auto mt-3">
  <div class="card-body d-flex justify-content-between align-items-center">
    <div>
    <h6 class=" mb-2 text-muted"><?=$suffix?></h6>
    <p class="card-text"><?=$trans['created_at']?></p>
</div>
<h4 class="card-title text-<?=$color?>"><b><?=$color=='danger'?'-':'+'?> <?=$trans['amount']?> Rs</b></h4>
  </div>
</div>
    <?php
}

?>

</div>
</div>



<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <form action="" method="post">
    <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Send Money</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
          <div>
          <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Mobile</span>
        <input type="text" class="form-control" id="user_mobile_no" placeholder="enter user mobile no..." aria-label="Username" aria-describedby="basic-addon1">
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Amount</span>
        <input type="text" class="form-control" id="amount" placeholder="enter amount to send.." aria-label="Username" aria-describedby="basic-addon1">
      </div>
      </div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hide</button>
        <button type="submit" id="send_money" class="btn btn-primary" name="sendmoney">Send Money</button>
      </div>
    </form>

    </div>
  </div>
</div>




<div class="modal fade" id="Deposit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="" method="post">
      <div class="modal-header">
        <h5 class="modal-title">Deposit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">Amount</span>
          <input type="number" name="depositeno" class="form-control" id="amount" placeholder="enter amount to insert.." aria-label="Username" aria-describedby="basic-addon1">
        </div>
      </div>

      

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="d" class="btn btn-primary">Deposit</button>
      </div>
      </form>
    </div>
  </div>
</div>






<div class="modal fade" id="withdraw" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="" method="post">
    <div class="modal-header">
        <h5 class="modal-title">withdraw</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Amount</span>
        <input type="number" class="form-control" id="amount" name ="withdrawno" placeholder="enter amount to withdraw.." aria-label="Username" aria-describedby="basic-addon1">
      </div>
      </div>

      

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="w">withdraw</button>
      </div>
    </form>
    

    </div>
  </div>
</div>



