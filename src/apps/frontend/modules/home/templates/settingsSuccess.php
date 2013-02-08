<form method="post" action="/home/show_settings" >
<table style="text-align: left; width: 100%;" border="0" cellpadding="2"
cellspacing="2">
<tbody>
<tr>
<td colspan="2" rowspan="1"
style="vertical-align: top; width: 358px;">What is your name?<br/>
    <?php echo $form['name']->render(array('value'=>$sf_user->getAttribute('name')))?>
    <br/>
</td>
</tr>
<tr>
<td colspan="1" rowspan="1"
style="vertical-align: top; width: 339px;">Password<br/>
    <?php echo $form['password']?><br/>
</td>
<td style="vertical-align: top; width: 358px;">Repeat password<br/>
    <?php echo $form['password_2']?><br/>
</td>
</tr>
<tr>
<td colspan="2" rowspan="1"
style="vertical-align: top; width: 338px;">
<fieldset><legend>Email to my inbox</legend><br>
<table style="text-align: left; width: 100%;" border="0"
cellpadding="2" cellspacing="2">
<tbody>
<tr>
<td style="vertical-align: top;">Server<br>
</td>
<td style="vertical-align: top;"><?php echo $form['server_name']?><br>
</td>
<td style="vertical-align: top;"><?php echo $form['tipo'] ?><br/>
    <br/>
</td>
</tr>
<tr>
<td style="vertical-align: top;">Username<br>
</td>
<td style="vertical-align: top;"><?php echo $form['username_server']?><br>
</td>
<td style="vertical-align: top;"><br>
</td>
</tr>
<tr>
<td style="vertical-align: top;">Password<br>
</td>
<td style="vertical-align: top;"><?php echo $form['password_server']?><br>
</td>
<td style="vertical-align: top;"><br>
</td>
</tr>
</tbody>
</table>
</fieldset>
</td>
</tr>
</tbody>
</table>
<input type="submit" value="Save" />
</form>
