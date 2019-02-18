import React from 'react'
import Dropzone from "react-dropzone";
import Preview from './Preview';

class UploadFile extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            accepted: [],
            rejected: []
        }
    }

    handleDrop = (file) => {
        this.props.uploadFile(file[0], this.state.id);
    };

    allowedFileTypes = () => {
        let {type} = this.props.fileType;

        if (type === 'audio') {
            return 'audio/mpeg, audio/mp3';
        }

        return 'image/jpeg, image/png';

    }


    render() {

        let {fileLocation, fileType} = this.props;

        return (
            <div>
                <Preview type={fileType} fileLocation={fileLocation} />
                <div className="dropzone">
                    <Dropzone
                        onDrop={this.handleDrop}
                    >
                        {({ getRootProps, getInputProps }) => (
                            <div {...getRootProps()}  className="dropzone">
                                <input {...getInputProps()} />
                                <p>Upload {fileType} here</p>
                            </div>
                        )}
                    </Dropzone>
                </div>
            </div>
        )
    }
}

export default UploadFile