@echo off 
START C:\TCCARGO\tccargo.exe
timeout/t 60
python index.py %*
pause
