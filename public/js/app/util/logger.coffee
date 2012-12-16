define (require,exports,module)->
  # LOGGER
  Logger =
    # logger object , proxy pour console.log
    state:off
    trace:off
    log :(args...)->
      if @trace is on
        console.trace()
      if @state is on
        console.log "Logged@logger ;)" , args
      return

  exports.Logger = Logger


