<?php
/**
 * COmanage Registry CO Group Name Validators View
 */

  // Add breadcrumbs
  print $this->element("coCrumb");
  $this->Html->addCrumb(_txt('ct.group_name_validators.pl'));

  // Add page title
  $params = array();
  $params['title'] = $title_for_layout;

  // Add top links
  $params['topLinks'] = array();

  if($permissions['add'] && !$vv_active_validator) {
    $params['topLinks'][] = $this->Html->link(
      _txt('op.add-a',array(_txt('ct.group_name_validators.1'))),
      array(
        'controller' => 'group_name_validators',
        'action' => 'add',
        'co' => $cur_co['Co']['id']
      ),
      array('class' => 'addbutton')
    );
  }

  print $this->element("pageTitleAndButtons", $params);

?>

<div class="table-container">
  <table id="group_name_validators">
    <thead>
    <tr>
      <th><?php print _txt('fd.desc'); ?></th>
      <th><?php print _txt('fd.status'); ?></th>
      <th><?php print _txt('fd.actions'); ?></th>
    </tr>
    </thead>

    <tbody>
    <?php $i = 0; ?>
    <?php foreach ($group_name_validators as $c): ?>
      <tr class="line<?php print ($i % 2)+1; ?>">
        <td>
          <?php
          print $this->Html->link($c['GroupNameValidator']['description'],
            array('controller' => 'group_name_validators',
              'action' => ($permissions['edit'] ? 'edit' : ($permissions['view'] ? 'view' : '')), $c['GroupNameValidator']['id'], 'co' => $cur_co['Co']['id']));
          ?>
        </td>
        <td><?php print _txt('en.status.susp', null, $c['GroupNameValidator']['status']); ?></td>
        <td>
          <?php
          if($permissions['edit']) {
            print $this->Html->link(_txt('op.edit'),
                array('controller' => 'group_name_validators', 'action' => 'edit', $c['GroupNameValidator']['id'], 'co' => $cur_co['Co']['id']),
                array('class' => 'editbutton')) . "\n";
          }
          if($permissions['delete']) {
            print '<button type="button" class="deletebutton" title="' . _txt('op.delete')
              . '" onclick="javascript:js_confirm_generic(\''
              . _txt('js.delete') . '\',\''    // dialog body text
              . $this->Html->url(              // dialog confirm URL
                array(
                  'controller' => 'group_name_validators',
                  'action' => 'delete',
                  $c['GroupNameValidator']['id'],
                  'co' => $cur_co['Co']['id']
                )
              ) . '\',\''
              . _txt('op.remove') . '\',\''    // dialog confirm button
              . _txt('op.cancel') . '\',\''    // dialog cancel button
              . _txt('op.remove') . '\',[\''   // dialog title
              . filter_var(_jtxt($c['GroupNameValidator']['description']),FILTER_SANITIZE_STRING)  // dialog body text replacement strings
              . '\']);">'
              . _txt('op.delete')
              . '</button>';
          }
          ?>
        </td>
      </tr>
      <?php $i++; ?>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
