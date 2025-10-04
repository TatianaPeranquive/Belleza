CREATE INDEX idx_resumen_cat1 ON resumen_centralizado (categoria_1);
CREATE INDEX idx_resumen_cat1_cat2 ON resumen_centralizado (categoria_1, categoria_2);
CREATE INDEX idx_resumen_cat1_cat2_cat3 ON resumen_centralizado (categoria_1, categoria_2, categoria_3);


SELECT * FROM pg_indexes WHERE tablename = "resumen_centralizado";
