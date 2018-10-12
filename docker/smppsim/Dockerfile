FROM java:8

RUN curl -L -o /usr/local/SMPPSim.tar.gz 'https://drive.google.com/uc?id=0B7YOzDQMt_TmS2lNMlpndnJndDA&export=download' && \
    tar xzf /usr/local/SMPPSim.tar.gz && \
    rm -f /usr/local/SMPPSim.tar.gz

#COPY conf/smppsim.props SMPPSim/conf/

EXPOSE 88 2775 2776

WORKDIR SMPPSim

RUN chmod +x startsmppsim.sh
CMD ./startsmppsim.sh