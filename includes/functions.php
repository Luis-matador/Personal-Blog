<?php
// Funciones auxiliares

// Guardar mensaje flash en sesión
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

// Validar imagen subida
function validateImage($file, &$errors, $maxSize = 10485760) {
	
	// Validar que se subió un archivo
	if ($file['error'] === UPLOAD_ERR_NO_FILE) {
		return true; // No es error si no se subió archivo (es opcional)
	}
	
	// Validar errores de subida
	if ($file['error'] !== UPLOAD_ERR_OK) {
		$errors[] = "Error al subir la imagen (código: {$file['error']}).";
		return false;
	}
	
	// Validar tipo MIME
	$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg'];
	if (!in_array($file['type'], $allowedTypes)) {
		$errors[] = "El tipo de imagen no es válido. Solo se permiten: JPG, PNG, GIF, WEBP.";
		return false;
	}
	
	// Validar extensión real del archivo
	$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
	$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
	if (!in_array($ext, $allowedExtensions)) {
		$errors[] = "La extensión del archivo no es válida. Solo se permiten: jpg, png, gif, webp.";
		return false;
	}
	
	// Validar tamaño
	if ($file['size'] > $maxSize) {
		$maxMB = round($maxSize / 1048576, 1);
		$errors[] = "La imagen supera el tamaño máximo permitido de {$maxMB}MB.";
		return false;
	}
	
	return true;
}

// Subir y guardar imagen
function uploadImage($file, $oldImage = null) {
	$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
	$safeName = uniqid('img_') . '.' . $ext;
	$uploadDir = __DIR__ . '/../public/uploads/';
	
	// Crear directorio si no existe
	if (!is_dir($uploadDir)) {
		mkdir($uploadDir, 0755, true);
	}
	
	$targetPath = $uploadDir . $safeName;
	
	// Mover archivo temporalmente
	if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
		return null;
	}
	
	// Redimensionar y comprimir imagen
	$resized = resizeImage($targetPath, 1200);
	
	if ($resized) {
		// Eliminar imagen anterior si existe
		if ($oldImage && file_exists(__DIR__ . '/../public' . $oldImage)) {
			unlink(__DIR__ . '/../public' . $oldImage);
		}
		return '/uploads/' . $safeName;
	}
	
	// Si falla el redimensionado, eliminar archivo y devolver null
	unlink($targetPath);
	return null;
}

// Redimensionar imagen
function resizeImage($filePath, $maxWidth = 1200) {
	// Verificar que GD esté disponible
	if (!extension_loaded('gd')) {
		return true; // Si GD no está disponible, no redimensionar
	}
	
	// Obtener información de la imagen
	$imageInfo = getimagesize($filePath);
	if ($imageInfo === false) {
		return false;
	}
	
	list($width, $height, $type) = $imageInfo;
	
	// Si la imagen ya es más pequeña que el máximo, solo comprimir
	if ($width <= $maxWidth) {
		return compressImage($filePath, $type);
	}
	
	// Calcular nuevas dimensiones manteniendo proporción
	$ratio = $height / $width;
	$newWidth = $maxWidth;
	$newHeight = (int)($newWidth * $ratio);
	
	// Crear imagen desde el archivo original
	switch ($type) {
		case IMAGETYPE_JPEG:
			$sourceImage = imagecreatefromjpeg($filePath);
			break;
		case IMAGETYPE_PNG:
			$sourceImage = imagecreatefrompng($filePath);
			break;
		case IMAGETYPE_GIF:
			$sourceImage = imagecreatefromgif($filePath);
			break;
		case IMAGETYPE_WEBP:
			$sourceImage = imagecreatefromwebp($filePath);
			break;
		default:
			return false;
	}
	
	if ($sourceImage === false) {
		return false;
	}
	
	// Crear imagen redimensionada
	$resizedImage = imagecreatetruecolor($newWidth, $newHeight);
	
	// Preservar transparencia para PNG y GIF
	if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
		imagealphablending($resizedImage, false);
		imagesavealpha($resizedImage, true);
		$transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
		imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
	}
	
	// Redimensionar
	imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
	
	// Guardar imagen redimensionada con compresión
	$result = false;
	switch ($type) {
		case IMAGETYPE_JPEG:
			$result = imagejpeg($resizedImage, $filePath, 85); // 85% calidad
			break;
		case IMAGETYPE_PNG:
			$result = imagepng($resizedImage, $filePath, 6); // Compresión nivel 6 (0-9)
			break;
		case IMAGETYPE_GIF:
			$result = imagegif($resizedImage, $filePath);
			break;
		case IMAGETYPE_WEBP:
			$result = imagewebp($resizedImage, $filePath, 85); // 85% calidad
			break;
	}
	
	// Liberar memoria
	imagedestroy($sourceImage);
	imagedestroy($resizedImage);
	
	return $result;
}

// Comprimir imagen
function compressImage($filePath, $type) {
	switch ($type) {
		case IMAGETYPE_JPEG:
			$image = imagecreatefromjpeg($filePath);
			if ($image === false) return false;
			$result = imagejpeg($image, $filePath, 85);
			imagedestroy($image);
			return $result;
			
		case IMAGETYPE_PNG:
			$image = imagecreatefrompng($filePath);
			if ($image === false) return false;
			imagealphablending($image, false);
			imagesavealpha($image, true);
			$result = imagepng($image, $filePath, 6);
			imagedestroy($image);
			return $result;
			
		case IMAGETYPE_WEBP:
			$image = imagecreatefromwebp($filePath);
			if ($image === false) return false;
			$result = imagewebp($image, $filePath, 85);
			imagedestroy($image);
			return $result;
			
		default:
			return true;
	}
}