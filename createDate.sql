CREATE TABLE notes
(
  note_id      int       NOT NULL AUTO_INCREMENT,
  note_date    char(50)  NOT NULL ,
  note_content char(100)     NULL ,
  PRIMARY KEY (note_id)
) ENGINE=InnoDB;


##########################
# Populate customers table
##########################
INSERT INTO notes(note_id, note_date, note_content)
VALUES(1, '2021-11-22 22:22:21', 'test date/time content');
