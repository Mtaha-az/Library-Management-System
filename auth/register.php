<?php
// Public admin self-registration is disabled.
// Admin accounts for this academic project should be provisioned directly
// by the database owner rather than created by anonymous visitors.
header("Location: ../index.php?msg=Admin+registration+is+disabled");
exit();
?>
