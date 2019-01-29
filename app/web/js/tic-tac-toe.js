$(function() {
    const game = $('.tic-tac-toe');
    const level = $('#level').val();

    const rand = Math.floor(Math.random() * 100);
    let player = rand < 50 ? 'player-1' : 'player-2';

    const block1 = $('#block-1-1');
    const block2 = $('#block-2-1');
    const block3 = $('#block-3-1');
    const block4 = $('#block-1-2');
    const block5 = $('#block-2-2');
    const block6 = $('#block-3-2');
    const block7 = $('#block-1-3');
    const block8 = $('#block-2-3');
    const block9 = $('#block-3-3');

    const winnersBlocks = [
        [block1, block2, block3],
        [block4, block5, block6],
        [block7, block8, block9],
        [block1, block4, block7],
        [block2, block5, block8],
        [block3, block6, block9],
        [block1, block5, block9],
        [block7, block5, block3],
    ];


    function changePlayer() {
        if (player === 'player-1') {
            player = 'player-2';
            return;
        }
        player = 'player-1';
    }

    function checkWinner() {
        const blocksSelected = $('.block.player-1,.block.player-2').length;
        if (blocksSelected < 5) {
            return;
        }

        function checkWinner(currentBlocks, playerClass, winnerClass) {
            let hasWon = currentBlocks[0].hasClass(playerClass)
                && currentBlocks[1].hasClass(playerClass)
                && currentBlocks[2].hasClass(playerClass);
            if (hasWon) {
                game.addClass('finished')
                    .addClass(winnerClass);
                return true;
            }
            return false;
        }

        let hasWinner = false;
        winnersBlocks.forEach(function(currentBlocks) {
            const playerOneWin = checkWinner(currentBlocks, 'player-1', 'winner-player-1');
            const playerTwoWin = checkWinner(currentBlocks, 'player-2', 'winner-player-2');
            if (playerOneWin || playerTwoWin) {
                hasWinner = true;
            }
        });

        if (blocksSelected === 9) {
            game.addClass('finished')
                .addClass('tie');
        }
        return hasWinner;
    }

    function makeMove($el) {
        $el.addClass(player).unbind('click');
        game.removeClass(player);
        changePlayer();
        const hasWinner = checkWinner();
        if (hasWinner) {
            return;
        }
        game.addClass(player);
        game.trigger('changeTurn');
    }

    $('.block').on('click', function(){
        if (game.hasClass('player-2')) {
            return;
        }
        let $el = $(this);
        makeMove($el);
    });

    game.on('changeTurn', function () {
        if (game.hasClass('player-1')) {
            return;
        }

        const player_one_char = $('#player_one_char').val();
        const player_two_char = $('#player_two_char').val();
        const slot_block1 = block1.hasClass('player-1') ? player_one_char : block1.hasClass('player-2') ? player_two_char : '';
        const slot_block2 = block2.hasClass('player-1') ? player_one_char : block2.hasClass('player-2') ? player_two_char : '';
        const slot_block3 = block3.hasClass('player-1') ? player_one_char : block3.hasClass('player-2') ? player_two_char : '';
        const slot_block4 = block4.hasClass('player-1') ? player_one_char : block4.hasClass('player-2') ? player_two_char : '';
        const slot_block5 = block5.hasClass('player-1') ? player_one_char : block5.hasClass('player-2') ? player_two_char : '';
        const slot_block6 = block6.hasClass('player-1') ? player_one_char : block6.hasClass('player-2') ? player_two_char : '';
        const slot_block7 = block7.hasClass('player-1') ? player_one_char : block7.hasClass('player-2') ? player_two_char : '';
        const slot_block8 = block8.hasClass('player-1') ? player_one_char : block8.hasClass('player-2') ? player_two_char : '';
        const slot_block9 = block9.hasClass('player-1') ? player_one_char : block9.hasClass('player-2') ? player_two_char : '';

        const map = [
            [slot_block1, slot_block2, slot_block3],
            [slot_block4, slot_block5, slot_block6],
            [slot_block7, slot_block8, slot_block9],
        ];

        $.ajax({
            url: 'http://localhost/api/' + level + '/nextMovement',
            method: 'post',
            contentType: 'application/json',
            data: JSON.stringify({
                'map': map,
                'playerUnit': player_two_char
            }),
            dataType: 'json',
            success: function(data) {
                const blockName = '#block-' + (data.x+1) + '-' + (data.y+1);
                const obj = $(blockName);
                makeMove(obj);
            }
        });
    });

    if ($('#wait_player').length === 0) {
        game.addClass(player).trigger('changeTurn');
    }
});
