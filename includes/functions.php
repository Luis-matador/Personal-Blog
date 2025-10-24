<?php
/**
 * Funciones auxiliares para usar en toda la aplicación
 * Por ejemplo:
 * - flashMessage($type, $message): guardar un mensaje flash en sesión
 * - getFlashMessage($type): obtener y eliminar un mensaje flash
 * - redirect($url): redirigir a otra página
 * - escape($string): escapar HTML para seguridad
 * - isLoggedIn(): verificar si el usuario está autenticado
 */

function flashMessage($type, $message) {
	if (session_status() === PHP_SESSION_NONE) session_start();
	$_SESSION['flash'][$type] = $message;
}

function getFlashMessage($type) {
	if (session_status() === PHP_SESSION_NONE) session_start();
	if (!empty($_SESSION['flash'][$type])) {
		$msg = $_SESSION['flash'][$type];
		unset($_SESSION['flash'][$type]);
		return $msg;
	}
	return null;
}

function redirect($url) {
	header('Location: ' . $url);
	exit;
}