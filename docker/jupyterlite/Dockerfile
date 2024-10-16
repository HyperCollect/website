FROM python:3.11-slim

WORKDIR /app

RUN pip install jupyterlite-pyodide-kernel importlib_resources jupyterlab_server
RUN jupyter lite init
# RUN jupyter lite build
EXPOSE 8000

CMD ["sh", "-c", "jupyter lite build && jupyter lite serve"]
