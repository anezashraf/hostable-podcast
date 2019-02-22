import React from 'react'
import UploadFile from "./UploadFile";

class CreateEpisodeForm extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            episode: {
            },
        }
    }

    componentDidMount() {
        let {episode} = this.props;

        this.setState({episode: episode});
    }

    handleTitleChange = (e) => {
        this.setState({title :e.target.value});
    };

    handleDescriptionChange = (e) => {
        this.setState({description: e.target.value});
    };

    handleSave = (e) => {
        this.props.handleSave(this.props.title, this.props.description)
    }

    uploadImage = (file) => {
        this.props.uploadImage(file, this.props.episode.id);
    }

    uploadAudio = (file) => {
        this.props.uploadAudio(file, this.props.episode.id);
    }

    render() {

        let {episode} = this.state;


        return (
            <div>
                <form onSubmit={this.handleSave}>
                    <label>title</label>
                    <input type="text" name="title" value={this.props.title} onChange={this.handleTitleChange}/>
                    <input type="text" name="description" value={this.props.description} onChange={this.handleDescriptionChange}/>
                    <button type="submit">Save</button>
                </form>
                <UploadFile isLoading={this.props.isImageUploading} fileType="image" fileLocation={this.props.imageFileLocation} uploadFile={this.uploadImage} />
                <UploadFile isLoading={this.props.isAudioUploading} fileType="audio" fileLocation={this.props.audioFileLocation} uploadFile={this.uploadAudio} />
            </div>
        )
    }
}

export default CreateEpisodeForm