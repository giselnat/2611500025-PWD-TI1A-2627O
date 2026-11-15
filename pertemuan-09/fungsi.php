<?php
function bersihkan($teks) 
{
 return htmlspecialchars($teks["nama"] ??"", ENT_QUOTES, "UTF-8");
}
