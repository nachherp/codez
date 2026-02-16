# Prompt pro para mejorar la vista de cliente de DentHub

Actúa como un **equipo senior de Producto** compuesto por: **Lead UX/UI Designer, CRO Specialist, Frontend Architect (HTML/CSS/JS), experto en accesibilidad WCAG 2.2 y redactor UX**.

Tu misión es rediseñar al máximo nivel la **vista de cliente** del proyecto **DentHub** (clínica dental), manteniendo una experiencia moderna, clara, confiable y orientada a que el paciente **agende y gestione citas sin fricción**.

## Contexto real del proyecto (úsalo sí o sí)
- El proyecto es un sitio web de clínica dental llamado **DentHub**.
- Tiene páginas de inicio, servicios, citas, registro/login y paneles de cliente/admin.
- En la vista actual del cliente se muestran:
  - Perfil básico (foto, nombre, email, teléfono).
  - Información adicional y pendientes de citas.
- El stack actual es principalmente **HTML/CSS/JS + PHP**.
- Existe navegación entre módulos como:
  - `vista_cliente/index.html`
  - `vista_cliente/administrar_cita/agendar/index.php`
  - `vista_cliente/calendario_cliente/index.html`
  - `vista_cliente/servicios/index.html`
- Tono de marca esperado: **profesional, humano, limpio, moderno, confiable (salud)**.

## Objetivo principal de negocio
Mejorar la vista del cliente para:
1. Aumentar agendamiento/reagendamiento de citas.
2. Reducir confusión del usuario al revisar próximas citas.
3. Transmitir confianza clínica (higiene, profesionalismo, seguridad de datos).
4. Mejorar experiencia móvil y accesibilidad.

## Entregables obligatorios
1. **Auditoría UX/UI de la vista actual**
   - Problemas críticos (jerarquía, contraste, legibilidad, navegación, contenido repetido, CTAs ausentes/confusos).
   - Qué afecta conversión y retención.
2. **Propuesta de arquitectura de información** para la vista cliente (orden ideal de bloques).
3. **Rediseño visual completo** con estilo premium sanitario:
   - Paleta sugerida (primarios, secundarios, estados, fondo).
   - Tipografías recomendadas y escala.
   - Sistema de espaciado y componentes (cards, botones, inputs, badges, timeline de citas).
4. **Wireframe textual (desktop + mobile)**
   - Header, resumen clínico, próximas citas, acciones rápidas, historial, soporte/contacto, etc.
5. **Copy UX listo para usar**
   - Títulos, subtítulos, labels, mensajes vacíos, errores, confirmaciones, CTA principal y secundarios.
6. **Estrategia CRO específica para clínica dental**
   - Dónde poner CTAs (“Agendar cita”, “Reagendar”, “Cancelar”, “Contactar clínica”).
   - Gatillos de confianza: testimonios, años de experiencia, certificaciones, protocolos de higiene, aviso de privacidad.
7. **Accesibilidad + performance**
   - Checklist WCAG 2.2 AA (contraste, foco visible, navegación teclado, alt text).
   - Optimización de carga (imágenes, CSS, JS, fuentes).
8. **Plan de implementación técnico por fases**
   - Fase 1 (quick wins, 1 semana)
   - Fase 2 (1 mes)
   - Fase 3 (optimización continua con A/B testing)
9. **KPIs y medición**
   - CVR de agendamiento, CTR en CTAs, tiempo a completar cita, rebote, retención de pacientes.

## Restricciones y enfoque técnico
- Propón una solución **compatible con el stack actual (HTML/CSS/JS/PHP)** sin depender de un framework pesado.
- Prioriza cambios que se puedan aplicar incrementalmente sobre la estructura actual del proyecto.
- Cada recomendación debe incluir:
  - **Impacto esperado** (alto/medio/bajo)
  - **Esfuerzo estimado** (alto/medio/bajo)
  - **Razón UX/CRO**

## Formato de salida (estricto)
Responde exactamente con estas secciones:
1. **Resumen ejecutivo**
2. **Auditoría de la vista actual (DentHub)**
3. **Rediseño propuesto (UI + UX + CRO)**
4. **Wireframe textual desktop**
5. **Wireframe textual mobile**
6. **Copy UX/UI listo para implementar**
7. **Checklist técnico (frontend + accesibilidad + performance)**
8. **Roadmap por fases**
9. **KPIs y plan de medición**
10. **Top 10 mejoras priorizadas (impacto vs esfuerzo)**

Si faltan datos, incluye primero una sección breve llamada **Supuestos** y luego entrega la propuesta completa sin detenerte.
