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


    render() {

        let {fileLocation, fileType, isLoading} = this.props;



        let preview = <p><b>Currently Loading Please Wait This Could Take Some Time..</b></p>

        if (! isLoading) {
            preview = <Preview type={fileType} fileLocation={fileLocation} />
        }

        let acceptedFileTypes = 'image/jpeg, image/png';


        if (fileType === 'audio') {
            acceptedFileTypes = 'audio/mpeg, audio/mp3';
        }

        return (
            <div>
                {preview}
                <div className="dropzone">
                    <Dropzone
                        accept={acceptedFileTypes}
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