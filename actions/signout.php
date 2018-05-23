<?php

if($user->sign_out()) {
	header('Location: ../session/');
}