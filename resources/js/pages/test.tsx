import React from 'react';

interface Tag {
    name: string;
    color: string;
    icon: string;
}

interface Like {
    id: number;
    user_id: number;
}

interface View {
    id: number;
    visitor_id: number;
}

interface Project {
    id: number;
    title: string;
    description: string;
    image_url: string;
    github_url: string;
    live_url: string;
    tags: Tag[];
    likes: Like[];
    views: View[];
}

interface Props {
    projects: Project[];
    tags: Tag[]
}

const TestPage: React.FC<Props> = ({ projects, tags }) => {
    return (
        <div className="projects-container">
            <h1>Projects</h1>
            <div className="projects-list">
                {projects.map((project) => (
                    <div key={project.id} className="project-card">
                        <img src={project.image_url} alt={project.title} />
                        <h2>{project.title}</h2>
                        <p>{project.description}</p>

                        <div className="tags">
                            {project.tags.map((tag) => (
                                <span
                                    key={tag.name}
                                    style={{ backgroundColor: tag.color }}
                                    className="tag"
                                >
                                    <i className={tag.icon}></i> {tag.name}
                                </span>
                            ))}
                        </div>

                        <div className="likes-views">
                            <p>Likes: {project.likes.length}</p>
                            <p>Views: {project.views.length}</p>
                        </div>

                        <div className="project-links">
                            <a href={project.github_url} target="_blank" rel="noopener noreferrer">GitHub</a>
                            <a href={project.live_url} target="_blank" rel="noopener noreferrer">Live Demo</a>
                        </div>
                    </div>
                ))}
            </div>
            <h1>Tags</h1>
            {
                tags.map((tag) => (
                    <div color={tag.color}>
                        <p>{tag.name}</p>
                        <span className={tag.icon}/>
                    </div>
                ))
            }
        </div>
    );
};

export default TestPage;
