
-- Add ordering column to matricula_info
ALTER TABLE matricula_info ADD COLUMN order_index INT DEFAULT 0;

-- Set initial order based on ID or existing logic
SET @rn = 0;
UPDATE matricula_info SET order_index = (@rn:=@rn+1) ORDER BY id;
