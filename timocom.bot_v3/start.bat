@echo off
set VERSION=4
REM проверяем версию selenium
python -c "import selenium; print('Selenium version', selenium.__version__)"
IF ERRORLEVEL 1 (
  REM selenium не установлен, устанавливаем
  echo Selenium не установлен, устанавливаю...
  pip install selenium
) ELSE (
  REM получаем версию selenium
  FOR /F "tokens=2 delims= " %%v IN ('python -c "import selenium; print(selenium.__version__)"') DO (
    REM проверяем, нужно ли обновлять selenium
    IF %%v LSS %VERSION% (
      echo Установлена версия Selenium %%v, нужно обновлять до %VERSION%...
      pip install selenium --upgrade
    ) ELSE (
      echo Версия Selenium %%v установлена и соответствует не менее %VERSION%...
    )
  )
)
REM запускаем start.py
echo "Запускаю start.py..."
python start.py %*
pause
