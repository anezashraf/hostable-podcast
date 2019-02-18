import React from 'react'
import UploadFile from "./UploadFile";

class EpisodeForm extends React.Component {

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
        let newEpisode = this.state.episode;

        newEpisode.title = e.target.value;
        this.setState({episode:newEpisode});
    };

    handleDescriptionChange = (e) => {
        let newEpisode = this.state.episode;

        newEpisode.description = e.target.value;
        this.setState({episode:newEpisode});
    };

    handleSave = (e) => {
        e.preventDefault();
        let {episode} = this.state;

        let data = [
            {op: "replace", path: "/title", value: episode.title},
            {op: "replace", path: "/description", value: episode.description},
        ];

        this.props.handleSave(episode.id, data)
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
                    <input type="text" name="title" value={episode.title} onChange={this.handleTitleChange}/>
                    <input type="text" name="description" value={episode.description} onChange={this.handleDescriptionChange}/>
                    <button type="submit">Save</button>
                </form>
                <UploadFile fileType="image" fileLocation={this.props.episode.image} uploadFile={this.uploadImage} />
                <UploadFile fileType="audio" fileLocation={this.props.episode.enclosureUrl} uploadFile={this.uploadAudio} />

            </div>
        )
    }
}

export default EpisodeForm