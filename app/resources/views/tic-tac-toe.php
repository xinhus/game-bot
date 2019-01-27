<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tic Tac Toe</title>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="js/tic-tac-toe.js?<?=time()?>"></script>
    <link rel="stylesheet" href="css/tic-tac-toe.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" crossorigin="anonymous">
    <style>
        <?php
            $playerOne = ($player == 'X')? '\f00d' : '\f10c';
            $playerTwo = ($player == 'X')? '\f10c' : '\f00d';
        ?>
        .tic-tac-toe.player-1 .block:after {
            content: "<?=$playerOne?>";
        }
        .tic-tac-toe .block.player-1:after {
            content: "<?=$playerOne?>" !important;
        }

        .tic-tac-toe.player-2 .block:after {
            content: "<?=$playerTwo?>";
        }
        .tic-tac-toe .block.player-2:after {
            content: "<?=$playerTwo?>" !important;
        }
    </style>
</head>
<body>

<div class="tic-tac-toe">

    <input type="hidden" value="<?= $player == 'X' ? 'X' : 'O'?>" id="player_one_char">
    <input type="hidden" value="<?= $player == 'X' ? 'O' : 'X'?>" id="player_two_char">
    <?php if (empty($player)): ?>
    <div class="start">
        <h3>Choose your player</h3>
        <a href="?player=X" class="fa fa-times"></a>
        <a href="?player=O" class="fa fa-circle-o"></a>
    </div>
    <?php endif; ?>

    <div id="block-1-1" class="block"></div>
    <div id="block-2-1" class="block"></div>
    <div id="block-3-1" class="block"></div>
    <div id="block-1-2" class="block"></div>
    <div id="block-2-2" class="block"></div>
    <div id="block-3-2" class="block"></div>
    <div id="block-1-3" class="block"></div>
    <div id="block-2-3" class="block"></div>
    <div id="block-3-3" class="block"></div>

    <div class="end">
        <h3></h3><a href="?">Restart</a>
    </div>
</div>


</body>
</html>
