<div id="body"><?= $kontrak->kontrakbody ?></div>
<table style="width:100%">
    <tr>
        <th style=" height:80px;vertical-align: top;">Pihak pertama</th>
        <th style=" height: 80px;vertical-align: top;">Pihak kedua</th>
        <th style=" height: 80px;vertical-align: top;">Pihak ketiga</th>
    </tr>
    <tr>
        <?php if ($kontrak->worker_signature == null) { ?>
            <td style="text-align: center; "><img src="data:image/gif;base64,<?=$default_img?>" alt="images" width="100px" style="opacity: 0.3;"></td>
        <?php } else { ?>
            <td style="text-align: center; "><img src="data:image/gif;base64,<?=$default_img?>" alt="images" width="100px" style="opacity: 0.3;"></td>
        <?php } ?>
        
        <?php if ($kontrak->owner_signature == null) { ?>
            <td style="text-align: center; "><img src="http://m-bangun.com/api/assets/20_siup.jpeg" alt="images" width="100px" style="opacity: 0.3;"></td>
        <?php } else { ?>
            <td style="text-align: center; "><img src="data:image/gif;base64,<?=$kontrak->owner_signature?>" alt="images" width="100px" style="opacity: 1;"></td>
        <?php } ?>

        <?php if ($kontrak->owner_signature == null) { ?>
            <td style="text-align: center; "><img src="http://m-bangun.com/api/assets/20_siup.jpeg" alt="images" width="100px" style="opacity: 0.3;"></td>
        <?php } else { ?>
            <td style="text-align: center; "><img src="data:image/gif;base64,<?=$kontrak->worker_signature?>" alt="images" width="100px" style="opacity: 1;"></td>
        <?php } ?>
    </tr>
    <tr>
        <td style="text-align: center; ">m-Bangun</td>
        <td style="text-align: center; "><?= $kontrak->owner_nama ?></td>
        <td style="text-align: center; "><?= $kontrak->worker_nama ?></td>
    </tr>
</table>