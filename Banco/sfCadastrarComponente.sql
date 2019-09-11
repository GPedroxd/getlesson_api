DELIMITER }
CREATE FUNCTION sfCadastrarComponente(nomeComponente varchar(80),siglaComponente varchar(10)) RETURNS INT
BEGIN
  IF nomeComponente!='' AND siglaComponente!='' THEN
      INSERT INTO tbComponente VALUES(null,nomeComponente,siglaComponente);
      RETURN (SELECT LAST_INSERT_ID());
  ELSE
      RETURN 0;
  END IF;
END
}