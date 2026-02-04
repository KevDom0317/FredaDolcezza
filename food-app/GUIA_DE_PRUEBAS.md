# 🧪 Guía de Pruebas - Sistema de Gestión de Comida

## 📋 Checklist de Pruebas

### ✅ FASE 1: Base de Datos y Modelos
- [x] Migraciones ejecutadas correctamente
- [x] Modelos creados con relaciones
- [x] Base de datos lista

### ✅ FASE 2: Gestión de Categorías
- [ ] Crear una categoría desde `/admin/categories/create`
- [ ] Editar una categoría existente
- [ ] Eliminar una categoría
- [ ] Subir imagen de categoría
- [ ] Verificar que solo admins pueden acceder

### ✅ FASE 3: Gestión de Productos
- [ ] Crear un producto desde `/admin/products/create`
- [ ] Asignar producto a una categoría
- [ ] Editar un producto existente
- [ ] Eliminar un producto
- [ ] Subir imagen de producto
- [ ] Verificar precios y disponibilidad

### ✅ FASE 4: Vista Pública del Menú
- [ ] Ver menú principal en `/`
- [ ] Ver productos agrupados por categorías
- [ ] Ver detalle de un producto en `/producto/{id}`
- [ ] Verificar que solo muestra productos disponibles

### ✅ FASE 5: Sistema de Carrito
- [ ] Agregar producto al carrito desde el menú
- [ ] Agregar producto al carrito desde el detalle
- [ ] Ver carrito en `/cart`
- [ ] Actualizar cantidad de productos
- [ ] Eliminar producto del carrito
- [ ] Vaciar carrito completo
- [ ] Verificar contador en el icono del carrito

---

## 🚀 Pasos para Probar el Sistema

### 1. Iniciar el Servidor

```bash
cd food-app
php artisan serve
```

El servidor estará disponible en: `http://localhost:8000`

### 2. Crear un Usuario Administrador

**Opción A: Desde la interfaz**
1. Ir a `http://localhost:8000/register`
2. Crear una cuenta
3. El usuario tendrá rol `admin` por defecto (según la migración)

**Opción B: Desde Tinker**
```bash
php artisan tinker
```
```php
User::create([
    'name' => 'Admin',
    'email' => 'admin@test.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);
```

### 3. Probar Panel de Administración

1. **Iniciar sesión** como admin en `http://localhost:8000/login`
2. **Acceder al panel** en `http://localhost:8000/admin`
3. **Crear categorías:**
   - Ir a "Gestionar categorías"
   - Crear categorías como: "Hamburguesas", "Bebidas", "Postres"
   - Subir imágenes (opcional)
   - Activar/desactivar categorías

4. **Crear productos:**
   - Ir a "Gestionar productos"
   - Crear productos asignándolos a categorías
   - Establecer precios
   - Subir imágenes (opcional)
   - Marcar como disponible/no disponible

### 4. Probar Vista Pública del Menú

1. **Cerrar sesión** o abrir en ventana de incógnito
2. **Ver menú principal** en `http://localhost:8000/`
3. **Verificar:**
   - Se muestran todas las categorías activas
   - Se muestran solo productos disponibles
   - Las imágenes se cargan correctamente
   - Los precios están formateados

4. **Ver detalle de producto:**
   - Hacer clic en "Ver Detalle" o "Ver"
   - Verificar información completa del producto

### 5. Probar Sistema de Carrito

1. **Agregar productos al carrito:**
   - Desde el menú: hacer clic en "Agregar"
   - Desde el detalle: seleccionar cantidad y hacer clic en "Agregar al Carrito"
   - Verificar mensaje de éxito

2. **Ver carrito:**
   - Hacer clic en el icono del carrito en el header
   - O ir directamente a `http://localhost:8000/cart`
   - Verificar que se muestran todos los productos agregados

3. **Actualizar cantidades:**
   - En el carrito, cambiar la cantidad de un producto
   - El formulario se envía automáticamente
   - Verificar que el total se actualiza

4. **Eliminar productos:**
   - Hacer clic en el icono de eliminar (papelera)
   - Verificar que el producto desaparece del carrito

5. **Vaciar carrito:**
   - Hacer clic en "Vaciar Carrito"
   - Confirmar la acción
   - Verificar que el carrito queda vacío

6. **Verificar contador:**
   - Agregar varios productos
   - Verificar que el número en el icono del carrito se actualiza

---

## 🐛 Problemas Comunes y Soluciones

### Error: "Storage link not found"
```bash
php artisan storage:link
```

### Error: "Route not found"
- Verificar que las rutas estén en `routes/web.php`
- Limpiar caché: `php artisan route:clear`
- Limpiar caché de configuración: `php artisan config:clear`

### Las imágenes no se muestran
- Verificar que el enlace simbólico existe: `php artisan storage:link`
- Verificar permisos de la carpeta `storage/app/public`
- Verificar que las imágenes se subieron correctamente

### El carrito no persiste
- Verificar que las sesiones estén configuradas correctamente
- Verificar el driver de sesión en `.env` (debe ser `file` o `database`)

### No puedo acceder al panel de admin
- Verificar que el usuario tenga `role = 'admin'` en la base de datos
- Verificar que el middleware `admin` esté registrado correctamente

---

## 📊 Datos de Prueba Sugeridos

### Categorías
- **Hamburguesas** (activa)
- **Bebidas** (activa)
- **Postres** (activa)
- **Acompañamientos** (activa)

### Productos de Ejemplo
- **Hamburguesa Clásica** - $15.99 - Categoría: Hamburguesas
- **Hamburguesa BBQ** - $18.99 - Categoría: Hamburguesas
- **Coca Cola** - $3.50 - Categoría: Bebidas
- **Agua** - $2.00 - Categoría: Bebidas
- **Helado** - $5.99 - Categoría: Postres

---

## ✅ Verificación Final

Antes de continuar con la FASE 6, asegúrate de que:

- [ ] Puedes crear y gestionar categorías
- [ ] Puedes crear y gestionar productos
- [ ] El menú público muestra correctamente los productos
- [ ] Puedes agregar productos al carrito
- [ ] Puedes ver y modificar el carrito
- [ ] Los totales se calculan correctamente
- [ ] Las imágenes se muestran correctamente
- [ ] El sistema de sesiones funciona (el carrito persiste)

---

## 🎯 Próximos Pasos

Una vez que hayas probado todo lo anterior, puedes continuar con:

**FASE 6: Sistema de Pedidos**
- Formulario de checkout
- Creación de pedidos
- Gestión de pedidos para administradores
- Cambio de estado de pedidos

¡Buena suerte con las pruebas! 🚀

