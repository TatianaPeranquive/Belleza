-- A) Filtrar por hito (solo nivel 1)
SELECT *
FROM resumen_centralizado
WHERE categoria_1 = 'Primer hito'
ORDER BY fecha DESC
LIMIT 50;

-- B) Hito + subcategoría 1
SELECT *
FROM resumen_centralizado
WHERE categoria_1 = 'Primer hito'
  AND categoria_2 = 'Familia'
ORDER BY fecha DESC;

-- C) Hito + sub1 + sub2 (cascada)
SELECT *
FROM resumen_centralizado
WHERE categoria_1 = 'Primer hito'
  AND categoria_2 = 'Familia'
  AND categoria_3 = 'Influencia';

-- D) Rango de fechas (aprovecha BRIN)
SELECT *
FROM resumen_centralizado
WHERE fecha BETWEEN DATE '2024-01-01' AND DATE '2024-12-31';

-- E) Buscar palabras en comentario (full-text)
SELECT *
FROM resumen_centralizado
WHERE comentario_tsv @@ plainto_tsquery('spanish', 'aprendizajes vestir');

------------------------------------------------------------------------------
------CONSULTAS EN CASCADA------------------------------------------------------

-- opciones de subcategoría 1 dado un hito
SELECT DISTINCT categoria_2
FROM resumen_centralizado
WHERE categoria_1 = :hito
  AND categoria_2 IS NOT NULL
ORDER BY categoria_2;

-- opciones de subcategoría 2 dado hito + sub1
SELECT DISTINCT categoria_3
FROM resumen_centralizado
WHERE categoria_1 = :hito
  AND categoria_2 = :sub1
  AND categoria_3 IS NOT NULL
ORDER BY categoria_3;

-- y asísucesivamente…
SELECT DISTINCT categoria_3
FROM resumen_centralizado
WHERE categoria_1 = 'Primer hito'
  AND categoria_2 = 'Familia'
  AND categoria_3 = 'Influencia'
  AND categoria_4 = 'Clase'
ORDER BY categoria_3;
