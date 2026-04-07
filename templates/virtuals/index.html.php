<p class="item">
 &nbsp;<a href="<?php echo $this->actions['new_url'] ?>"><?php echo $this->actions['new_text'] ?></a> |
 &nbsp;<a href="<?php echo $this->actions['users_url'] ?>"><?php echo $this->actions['users_text'] ?></a>
</p>

<?php if (!empty($this->virtuals)): ?>
<table class="horde-table">
 <tr class="item">
  <th>&nbsp;</th>
  <th>
   <?php echo _("Virtual Email Address") ?>
  </th>
  <th>
   <?php echo _("Destination") ?>
  </th>
 </tr>
<?php foreach ($this->virtuals as $virtual): ?>
 <tr>
  <td>
   <a href="<?php echo $virtual['edit_url'] ?>"><?php echo $this->images['edit'] ?></a>
   <a href="<?php echo $virtual['del_url'] ?>"><?php echo $this->images['delete'] ?></a>
  </td>
  <td>
   <?php echo $this->escape($virtual['virtual_email']) ?>
  </td>
  <td align="center">
   <?php echo $this->escape($virtual['virtual_destination']) ?>
  </td>
 </tr>
<?php endforeach ?>
</table>
<?php endif ?>
