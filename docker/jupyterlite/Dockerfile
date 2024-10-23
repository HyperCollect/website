ARG platform="linux/amd64"

FROM --platform=${platform} "jupyter/minimal-notebook"

USER root

ENV JULIA_VERSION=1.8.3

RUN mkdir /opt/julia-${JULIA_VERSION} && \
    cd /tmp && \
    wget -q https://julialang-s3.julialang.org/bin/linux/x64/`echo ${JULIA_VERSION} | cut -d. -f 1,2`/julia-${JULIA_VERSION}-linux-x86_64.tar.gz && \
    tar xzf julia-${JULIA_VERSION}-linux-x86_64.tar.gz -C /opt/julia-${JULIA_VERSION} --strip-components=1 && \
    rm /tmp/julia-${JULIA_VERSION}-linux-x86_64.tar.gz

RUN ln -fs /opt/julia-*/bin/julia /usr/local/bin/julia

USER $NB_UID

RUN julia -e 'import Pkg; Pkg.update()' && \
    julia -e 'import Pkg; Pkg.add("IJulia"); using IJulia' && \
    fix-permissions /home/$NB_USER

RUN jupyter notebook --generate-config
RUN echo "c.NotebookApp.tornado_settings={'headers': {'Content-Security-Policy': \"frame-ancestors * 'self' \"}}" >> /home/$NB_USER/.jupyter/jupyter_notebook_config.py
CMD ["jupyter", "notebook", "--NotebookApp.token=''","--NotebookApp.password=''"]