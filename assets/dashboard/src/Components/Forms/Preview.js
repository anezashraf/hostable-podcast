import React from 'react'
import Dropzone from "react-dropzone";

class Preview extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            accepted: [],
            rejected: []
        }
    }


    render() {

        let {type, fileLocation} = this.props;

        if (type === 'audio') {
            return <audio src={fileLocation} controls />
        }

        return <img src={fileLocation} width={250} height={250} />
    }
}

export default Preview