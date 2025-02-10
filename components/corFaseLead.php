<?php
$fase = consultarUltimaFaseLead($idLead);

if ($fase) {
    switch ($fase) {
        case 1:
            echo "<div class='fase-lead sem-contato'>
                    <span class='status semcontato'></span> Sem Contato
                </div>";
            break;
        case 2:
            echo "<div class='fase-lead queria-nada'>
                    <span class='status querianada'></span> Sem Interesse
                </div>";
            break;
        case 3:
            echo "<div class='fase-lead sem-ajuda'>
                    <span class='status semajuda'></span> Sem Solução
                </div>";
            break;
        case 4:
            echo "<div class='fase-lead ja-regularizou'>
                    <span class='status regularizado'></span> Regularizado
                </div>";
            break;
        case 5:
            echo "<div class='fase-lead em-aberto'>
                    <span class='status emaberto'></span> Em Aberto
                </div>";
            break;
        case 6:
            echo "<div class='fase-lead negociacao'>
            <span class='status negociacao'></span> Negociação
            </div>";
            break;
        case 7:
            echo "<div class='fase-lead nova-venda'>
            <span class='status venda'></span> Venda
            </div>";
            break;
        case 8:
            echo "<div class='fase-lead nosso-cliente'>
                    <span class='status cliente'></span> Cliente
                </div>";
            break;
        case 9:
            echo "<div class='fase-lead enviado-mensagem'>
                    <span class='status mensagem'></span> Enviado Mensagem
                </div>";
            break;
        case 10:
            echo "<div class='fase-lead achou-caro'>
            <span class='status achoucaro'></span> Achou Caro
            </div>";
            break;
        case 11:
            echo "<div class='fase-lead nao-responde'>
                    <span class='status naoresponde'></span> Parou de Responder
                </div>";
            break;
        default:
            echo "
            <div class='fase-lead nova-lead'>
                <span class='status semretorno'></span> Nova
            </div>
            ";
            break;
    }
} else {
    echo "<div class='fase-lead nova-lead'>
                <span class='status semretorno'></span> Nova
            </div>";
}
