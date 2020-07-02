<div id="body"><?= $kontrak->kontrakbody ?></div>
<table style="width:100%">
    <tr>
        <th style=" height:80px;vertical-align: top;">Pihak pertama</th>
        <th style=" height: 80px;vertical-align: top;">Pihak kedua</th>
        <th style=" height: 80px;vertical-align: top;">Pihak ketiga</th>
    </tr>
    <tr>
        <?php if ($kontrak->worker_signature == null) { ?>
            <td style="text-align: center; "><img src="' . base_url() . 'assets/images/logo/logo.png" alt="images" width="100px" style="opacity: 0.1;"></td>
        <?php } else { ?>
            <?= $kontrak->worker_signature ?>
        <?php } ?>
        <?php if ($kontrak->owner_signature == null) { ?>
            <td style="text-align: center; "><img src="' . base_url() . 'assets/images/logo/logo.png" alt="images" width="100px" style="opacity: 0.1;"></td>
        <?php } else { ?>
            <?= $kontrak->owner_signature ?>
        <?php } ?>
        <td style="text-align: center; "><img src="' . base_url() . 'assets/images/logo/logo.png" alt="images" width="100px" style="opacity: 0.1;"></td>
    </tr>
    <tr>
        <td style="text-align: center; ">m-Bangun</td>
        <td style="text-align: center; "><?= $kontrak->owner_nama ?></td>
        <td style="text-align: center; "><?= $kontrak->worker_nama ?></td>
    </tr>
</table>