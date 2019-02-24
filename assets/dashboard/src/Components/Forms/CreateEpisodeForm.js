import React from 'react'
import UploadFile from "./UploadFile";
import {withRouter} from 'react-router-dom';
class CreateEpisodeForm extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            imageFile: '',
            audioFile: '',
            episode: {
            },
        }
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        console.log("redirect please");
        console.log(prevProps.isNewEpisodeSaving);
        console.log(this.props.isNewEpisodeSaving);
        if (prevProps.isNewEpisodeSaving && false === this.props.isNewEpisodeSaving) {
            console.log("We're in the new episode");
            this.props.history.push('/dashboard/details');
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
        e.preventDefault();

        let {title, description, audioFile, imageFile} = this.state;

        this.props.handleSave(title, description, audioFile, imageFile);
    }

    handleImageDrop = (imageFile) => {
        this.setState({imageFile: imageFile});
    };

    handleAudioDrop = (audioFile) => {
        this.setState({audioFile: audioFile});
    };

    render() {

        let {episode} = this.state;
        let {isNewEpisodeSaving} = this.props;

        if (isNewEpisodeSaving) {
            return <p>Saving</p>
        }


        return (
            <div>
                <form onSubmit={this.handleSave}>
                    <label>title</label>
                    <input type="text" name="title" value={this.props.title} onChange={this.handleTitleChange}/>
                    <input type="text" name="description" value={this.props.description} onChange={this.handleDescriptionChange}/>
                    <button type="submit">Save</button>
                </form>
                <UploadFile
                    isLoading={false}
                    fileType="image"
                    fileLocation={this.props.imageFileLocation}
                    uploadFile={this.handleImageDrop}
                />

                <UploadFile
                    isLoading={false}
                    fileType="audio"
                    fileLocation={this.props.audioFileLocation}
                    uploadFile={this.handleAudioDrop}
                />
            </div>
        )
    }
}

export default withRouter(CreateEpisodeForm)
