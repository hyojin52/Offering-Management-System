CREATE TABLE income_item(
  income_item_id INT(5) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  item CHAR(20) NOT NULL,
  desc1 VARCHAR(200),
  desc2 VARCHAR(200),
  income_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO 'income_item' ('item') VALUES
('십일조'),
('감사'),
('주일'),
('부활'),
('맥추'),
('성탄'),
('추수'),
('기타헌금'),
('신년감사'),
('선교'),
('적립금인출'),
('건축헌금'),
('이월금'),
('차량구입'),
('차입금');
