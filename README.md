# Laravel Pizzería - Aplicación Basada en DDD

Este proyecto de Laravel implementa una solución basada en Domain-Driven Design (DDD) para la gestión de un catálogo de pizzas e ingredientes, sin utilizar la arquitectura hexagonal. A continuación se describen los aspectos clave de la implementación.

## Arquitectura y Dominio

### Domain-Driven Design (DDD)
El proyecto sigue un enfoque DDD para organizar el código, aunque **sin** aplicar la arquitectura hexagonal. La razón para no incluir la arquitectura hexagonal es que, en este caso, no se necesita la separación explícita de las capas externas e internas, lo que simplifica la estructura y mantiene el enfoque en el dominio.

### Dominio: `Menu`

El dominio principal en esta aplicación es `Menu`. Elegí este nombre porque refleja la estructura central del negocio: un menú de pizzas y sus ingredientes. El objetivo de este enfoque es asegurar que todo el código relacionado con la gestión del menú esté agrupado en un solo lugar, lo que facilita el desarrollo, el mantenimiento y la escalabilidad en el futuro. Todo lo que tiene que ver con la creación, modificación y eliminación de pizzas, ingredientes y sus precios se encuentra dentro de este dominio.

#### Beneficios de la organización por dominios

Este enfoque de DDD ofrece varios beneficios clave para el futuro del proyecto:

1. **Facilidad de Mantenimiento**: Todo el código relacionado con el negocio del menú está contenido en un solo lugar. Esto significa que, si en el futuro se necesita añadir o modificar funcionalidades relacionadas con pizzas o ingredientes, solo es necesario buscar en el dominio `Menu`. No hay necesidad de navegar por diferentes capas técnicas o directorios.

2. **Escalabilidad**: Si el proyecto crece y se añaden más funcionalidades, como gestionar órdenes o clientes, podemos crear nuevos dominios que se ajusten a esas necesidades, manteniendo el código modular y organizado.

3. **Onboarding**: Facilita el onboarding de nuevos desarrolladores, ya que la estructura del proyecto refleja el lenguaje del negocio. Un nuevo miembro del equipo podría ver el dominio `Menu` y comprender inmediatamente que ahí se maneja todo lo relacionado con el menú de la pizzería, sin necesidad de profundizar en detalles técnicos complejos.

4. **Separación de Preocupaciones**: Al aislar el código del negocio en dominios, se separa de las preocupaciones técnicas, como controladores HTTP o capas de infraestructura, que viven en otras partes de la aplicación. Esto permite que los desarrolladores se centren en la lógica del negocio sin distraerse con las complejidades de la implementación técnica.

En resumen, la creación del dominio `Menu` no solo refleja una buena práctica de DDD, sino que también prepara la aplicación para una fácil evolución y mantenimiento a largo plazo, adaptándose a futuros cambios en el negocio.

---
## Dependencias

He aplicado **cero dependencias/packages externos** en el proyecto para cumplir con la preferencia de utilizar únicamente las herramientas nativas que ofrece Laravel. Esto ayuda a mantener el proyecto ligero y sencillo, aprovechando al máximo las funcionalidades propias del framework.


## Seeder Automático

El proyecto incluye un **seeder** que genera automáticamente:
- **20 pizzas**
- **10 ingredientes**
- **1 usuario administrador** y **1 usuario cliente**.

Las credenciales de los usuarios son las siguientes:

- **Administrador:**
    - Correo: `admin@admin.com`
    - Contraseña: `QWERTY123`

- **Cliente:**
    - Correo: `client@client.com`
    - Contraseña: `12345678`

Dado que se especifica que el cliente debe poder ver las pizzas (con su información y precio calculado) y sus ingredientes, he añadido una **"landing page"** accesible en la ruta `/`. Esta página es visible para cualquier usuario, ya sea registrado o no, y muestra las pizzas junto con sus ingredientes y precios.

### Funcionalidades para usuarios registrados:
- Los usuarios que tengan el campo `is_admin = true` (como el administrador generado por el seeder) podrán, además de ver las pizzas, acceder al **CRUD** de ingredientes y pizzas, lo que les permitirá gestionar el menú.

### API Endpoint
El proyecto también incluye un endpoint de la API para listar las pizzas, disponible en la ruta:

```
/api/pizza
```

---

## Consideraciones sobre Packages y Herramientas de Terceros

Aunque en este proyecto no he utilizado paquetes adicionales, si fuera un proyecto real, habría considerado usar herramientas de alta calidad y confiabilidad como:
- **[Laravel Data](https://github.com/spatie/laravel-data)**: Para manejar y transformar los datos de forma más eficiente.
- **[Laravel Translatable](https://github.com/spatie/laravel-translatable)**: Para gestionar la internacionalización y los contenidos en varios idiomas.

## Frontend

El frontend no ha sido personalizado en profundidad, ya que no era el foco principal de esta prueba. Sin embargo, en un proyecto real, hubiera preferido utilizar **TailwindCSS** y **AlpineJS** en lugar de **Bootstrap** y **jQuery**, ya que ofrecen mayor flexibilidad y rendimiento.

Dicho esto, reconozco que hay proyectos antiguos que pueden requerir Bootstrap y jQuery para mantener la compatibilidad y facilidad de mantenimiento.

### Choices.js
Para mejorar los formularios, he añadido la dependencia **choices.js**, pero solo en los formularios, y lo he hecho de forma dinámica utilizando `@stack` y `@push` para cargar los scripts y estilos solo donde se necesita.

```blade
@push('styles')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/styles/choices.min.css"
    />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <script type="text/javascript">
        const element = document.querySelector('.js-choice');
        const choices = new Choices(element);
    </script>
@endpush
```

## Optimización y Cache

He decidido añadir el campo `total_price` a la tabla de pizzas. Este campo se actualiza mediante un sistema de cache que se refresca con eventos y acciones asincrónicas. Justificación: en el contexto de una pizzería, los precios e ingredientes de las pizzas no cambian con frecuencia, por lo que calcular el precio de cada pizza dinámicamente no es necesario en cada solicitud.

## CQRS (Command Query Responsibility Segregation)

El proyecto sigue el patrón **CQRS** (Separación de Responsabilidades entre Comandos y Consultas), pero he utilizado **ViewModels** y **Acciones** en lugar de Comandos o Repositorios. A nivel práctico, el concepto es similar, manteniendo la separación entre las responsabilidades de lectura y escritura, lo que facilita la escalabilidad y el mantenimiento del código.

## Nota sobre el Ejemplo del Precio

Me he ceñido al literal del enunciado, aunque el ejemplo proporcionado en la prueba muestra un cálculo de precio erróneo (una pizza Campagna tiene un precio de 10€, pero sus ingredientes suman 4,5€). El cálculo que he implementado utiliza correctamente la suma de los precios de los ingredientes más el 50% de dicha suma para obtener el precio final de la pizza.

---
