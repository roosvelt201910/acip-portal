-- Add video_hero column to programas_estudio table
-- This will store the path to uploaded video files for the hero section

ALTER TABLE programas_estudio 
ADD COLUMN video_hero VARCHAR(255) NULL AFTER imagen;
